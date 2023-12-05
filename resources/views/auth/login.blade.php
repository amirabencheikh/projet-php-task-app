<!DOCTYPE html>
<html>

<head>

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
      
    </style>
</head>

<body>
    <x-guest-layout>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />


        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                                <button type="button" class="btn btn-primary btn-floating mx-1" onclick="window.location.href='/login/facebook';">
                                    <i class="fab fa-facebook-f"></i>
                                    
                                </button>

                                <button type="button" class="btn btn-primary btn-floating mx-1"onclick="window.location.href='/login/google';">
                                    <i class="fab fa-google"></i>
                                   
                                </button>

                                
                            </div>

                            <div class="divider d-flex align-items-center my-4">
                                <p class="text-center fw-bold mx-3 mb-0">Or</p>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <label class="form-label" for="form3Example3" :value="__('Email')">Email address</label>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" name="password" required autocomplete="current-password" />
                                <label class="form-label" for="form3Example4" :value="__('Password')">Password</label>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Checkbox -->
                                <div class="form-check mb-0">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                    <label class="form-check-label" for="form2Example3">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                    @endif
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    
                                    <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ __('Log in') }}</button>
                                    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}" class="link-danger">Register</a></p>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
            
        </section>
    </x-guest-layout>
</body>

</html>