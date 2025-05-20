<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCreateController extends Controller
{
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Log that we're entering the create method
        \Log::info('Entering UserCreateController@create method');

        try {
            // Return the create view
            return view('users.create');
        } catch (\Exception $e) {
            // Log any errors
            \Log::error('Error in UserCreateController@create: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return a simple response for debugging
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => explode("\n", $e->getTraceAsString())
            ]);
        }
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Simplified user creation with minimal error-prone code
        try {
            // Validate the request
            $validated = $request->validate([
                "name" => "required|string|max:255",
                "email" => "required|email|unique:users",
                "password" => [
                    'required',
                    'min:10',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/',
                ],
                "password_confirmation" => "required|same:password",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "role" => "required|in:employee,admin",
            ]);

            // Prepare user data
            $userData = [
                "name" => $validated['name'],
                "email" => $validated['email'],
                "password" => Hash::make($validated['password']),
                "role" => $validated['role']
            ];

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('profile_images', 'public');
                $userData['image'] = 'storage/' . $path;
            }

            // Create the user
            $user = User::create($userData);

            // Create notification for user creation
            try {
                Notification::create([
                    'title' => 'New User Created',
                    'message' => 'New user "' . $user->name . '" has been created with ' . $user->role . ' role',
                    'type' => 'success',
                    'icon' => 'mdi mdi-account-plus',
                    'is_read' => false,
                    'link' => route('users.index'),
                    'user_id' => auth()->id()
                ]);
            } catch (\Exception $e) {
                // Just log notification errors, don't fail the whole process
                \Log::error('Failed to create notification: ' . $e->getMessage());
            }

            // Redirect with success message
            return redirect()->route("users.index")
                ->with("success", "User created successfully");

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->validator)
                        ->withInput($request->except(['password', 'password_confirmation']));

        } catch (\Exception $e) {
            // Handle other exceptions
            \Log::error('User creation failed: ' . $e->getMessage());

            return back()->withErrors(['general' => 'Failed to create user: ' . $e->getMessage()])
                        ->withInput($request->except(['password', 'password_confirmation']));
        }
    }
}
