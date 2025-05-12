<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Image') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your profile image.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-image') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        <div>
            <div class="profile-image-container">
                @if(auth()->user()->image)
                    <div class="current-image">
                        <img src="{{ asset(auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="profile-image">
                    </div>
                @else
                    <div class="profile-placeholder">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                
                <div class="image-upload">
                    <label for="image" class="custom-file-upload">
                        <i class="fas fa-camera"></i> Change Image
                    </label>
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/jpg">
                    <p class="image-help-text">Recommended: Square image, at least 200x200 pixels</p>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('success'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ session('success') }}</p>
            @endif
        </div>
    </form>

    <style>
        .profile-image-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .current-image {
            margin-right: 30px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #5985ee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 60px;
            margin-right: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .image-upload {
            flex: 1;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .custom-file-upload:hover {
            background-color: #e9ecef;
        }

        .custom-file-upload i {
            margin-right: 5px;
        }

        input[type="file"] {
            display: none;
        }

        .image-help-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // If there's already an image element
                            const existingImage = document.querySelector('.profile-image');
                            if (existingImage) {
                                existingImage.src = e.target.result;
                            } 
                            // If there's a placeholder, replace it with an image
                            else {
                                const placeholder = document.querySelector('.profile-placeholder');
                                if (placeholder) {
                                    const parent = placeholder.parentNode;
                                    
                                    const imageDiv = document.createElement('div');
                                    imageDiv.className = 'current-image';
                                    
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'profile-image';
                                    img.alt = 'Profile Preview';
                                    
                                    imageDiv.appendChild(img);
                                    parent.replaceChild(imageDiv, placeholder);
                                }
                            }
                        };
                        
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
    </script>
</section>
