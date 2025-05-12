<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    // No middleware needed here as it's handled in routes
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("users.index" , compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log the request data for debugging
        \Log::info('User creation attempt - START', [
            'request_data' => $request->all(),
            'is_ajax' => $request->ajax(),
            'wants_json' => $request->wantsJson(),
            'x_requested_with' => $request->header('X-Requested-With'),
            'session_id' => session()->getId(),
            'session_token' => csrf_token()
        ]);

        // Check if this is an AJAX request
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        // Add this debugging code
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!$file->isValid()) {
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['image' => ['Invalid file upload']]
                    ]);
                }
                return back()->withErrors(['image' => 'Invalid file upload']);
            }

            // Check MIME type
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['image' => ['File is not a valid image. Detected: ' . $mimeType]]
                    ]);
                }
                return back()->withErrors(['image' => 'File is not a valid image. Detected: ' . $mimeType]);
            }
        }

        // Validate that passwords match
        if ($request->password !== $request->password_confirmation) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'errors' => ['password_confirmation' => ['The password confirmation does not match.']]
                ]);
            }
            return back()->withErrors(['password_confirmation' => 'The password confirmation does not match.'])
                        ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Rest of your validation and processing
        try {
            // Log validation rules
            \Log::info('User creation validation rules', [
                'rules' => [
                    "name" => "required",
                    "email" => "required|email|unique:users",
                    "password" => "required",
                    "password_confirmation" => "required|same:password",
                    "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                    "role" => "nullable|in:employee,admin",
                ]
            ]);

            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users",
                "password" => "required",
                "password_confirmation" => "required|same:password", // Add validation rule for matching passwords
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "role" => "nullable|in:employee,admin",
            ]);

            if ($validator->fails()) {
                \Log::error('User creation validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);

                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ]);
                }
                return back()->withErrors($validator)->withInput($request->except(['password', 'password_confirmation']));
            }

            \Log::info('User creation validation passed');

            $userData = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role ?? 'employee' // Default to 'employee' if no role is provided
            ];

            \Log::info('User data prepared', [
                'userData' => array_merge($userData, ['password' => '[REDACTED]'])
            ]);

            if ($request->hasFile('image')) {
                try {
                    \Log::info('Processing image upload', [
                        'original_name' => $request->file('image')->getClientOriginalName(),
                        'mime_type' => $request->file('image')->getMimeType(),
                        'size' => $request->file('image')->getSize()
                    ]);

                    $path = $request->file('image')->store('profile_images', 'public');
                    $userData['image'] = 'storage/' . $path;

                    \Log::info('Image uploaded successfully', [
                        'path' => $path,
                        'full_path' => 'storage/' . $path
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                \Log::info('No image uploaded');
            }

            \Log::info('Creating user with data', [
                'final_user_data' => array_merge($userData, ['password' => '[REDACTED]'])
            ]);

            try {
                $user = User::create($userData);
                \Log::info('User created successfully', [
                    'user_id' => $user->id,
                    'user_email' => $user->email
                ]);
            } catch (\Exception $e) {
                \Log::error('User creation database error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e; // Re-throw to be caught by the outer try-catch
            }

            // Create notification for user creation
            try {
                \Log::info('Creating notification for new user');

                $notificationData = [
                    'title' => 'New User Created',
                    'message' => 'New user "' . $user->name . '" has been created with ' . $user->role . ' role',
                    'type' => 'success',
                    'icon' => 'mdi mdi-account-plus',
                    'is_read' => false,
                    'link' => route('users.show', $user->id),
                    'user_id' => auth()->id() // Add the user_id of the creator
                ];

                \Log::info('Notification data prepared', [
                    'notification_data' => $notificationData
                ]);

                $notification = Notification::create($notificationData);

                \Log::info('Notification created successfully', [
                    'notification_id' => $notification->id
                ]);
            } catch (\Exception $e) {
                \Log::error('Notification creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't throw the exception here, just log it
                // We still want to return success even if notification fails
            }

            \Log::info('User creation process completed successfully');

            if ($isAjax) {
                \Log::info('Returning AJAX success response');
                return response()->json([
                    'success' => true,
                    'redirect' => route('users.index'),
                    'message' => 'User created successfully'
                ]);
            }

            \Log::info('Redirecting to users.index with success message');
            return redirect()->route("users.index")
                ->with("success", "User created successfully");
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('User creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'errors' => ['general' => [$e->getMessage()]]
                ]);
            }

            return back()->withErrors(['general' => $e->getMessage()])
                        ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route("users.index")
                ->with("error", "User not found");
        }

        return view("users.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route("users.index")
                ->with("error", "User not found");
        }

        return view("users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the user
            $user = User::find($id);

            if (!$user) {
                return redirect()->route("users.index")
                    ->with("error", "User not found");
            }

            // Check if password is being updated
            $passwordRules = [];
            if ($request->filled('password')) {
                // Validate that passwords match
                if ($request->password !== $request->password_confirmation) {
                    return back()->withErrors(['password_confirmation' => 'The password confirmation does not match.'])
                                ->withInput($request->except(['password', 'password_confirmation']));
                }

                $passwordRules = [
                    "password" => "required|min:6",
                    "password_confirmation" => "required|same:password"
                ];
            }

            // Validate the request
            $validator = Validator::make($request->all(), array_merge([
                "name" => "required|string|max:255",
                "email" => "required|email|unique:users,email," . $id,
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "role" => "required|in:employee,admin"
            ], $passwordRules));

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->except(['password', 'password_confirmation']));
            }

            // Update user data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }

                // Store new image
                $path = $request->file('image')->store('profile_images', 'public');
                $user->image = 'storage/' . $path;
            }

            $user->save();

            // Create notification for user update
            try {
                Notification::create([
                    'title' => 'User Updated',
                    'message' => 'User "' . $user->name . '" has been updated',
                    'type' => 'warning',
                    'icon' => 'mdi mdi-account-edit',
                    'is_read' => false,
                    'link' => route('users.index'),
                    'user_id' => auth()->id() // Add the user_id of who updated the user
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't throw the exception, just log it
            }

            return redirect()->route("users.index")
                ->with("success", "User updated successfully");

        } catch (\Exception $e) {
            \Log::error('User update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['general' => 'Failed to update user: ' . $e->getMessage()])
                        ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the user to be deleted
        $user = User::find($id);

        if (!$user) {
            return redirect()->route("users.index")
                ->with("error", "User not found");
        }

        // Check if trying to delete the currently logged-in user
        if ($user->id === auth()->id()) {
            return redirect()->route("users.index")
                ->with("error", "You cannot delete your own account");
        }

        // Check if this is the last admin user
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route("users.index")
                    ->with("error", "Cannot delete the last admin user");
            }
        }

        // Store user name before deletion for notification
        $userName = $user->name;

        try {
            // Delete the user's image if it exists
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $user->delete();

            // Create notification for user deletion
            try {
                Notification::create([
                    'title' => 'User Deleted',
                    'message' => 'User "' . $userName . '" has been deleted',
                    'type' => 'danger',
                    'icon' => 'mdi mdi-account-remove',
                    'is_read' => false,
                    'link' => route('users.index'),
                    'user_id' => auth()->id() // Add the user_id of who deleted the user
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't throw the exception, just log it
            }

            return redirect()->route("users.index")
                ->with("warning", "User deleted successfully");
        } catch (\Exception $e) {
            \Log::error('User deletion failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route("users.index")
                ->with("error", "Failed to delete user: " . $e->getMessage());
        }
    }
}






















