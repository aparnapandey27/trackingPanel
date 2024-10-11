<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertiser Registration</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
        }

        h1 {
            color: #007bff;
            margin-bottom: 1.5rem;
        }

        .alert {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .form-control,
        .form-select {
            border-radius: 4px;
            border: 1px solid #ced4da;
            box-shadow: none;
            margin-bottom: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        .btn {
            display: inline-block;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container p-lg-5 p-4">
        <h1 class="text-primary">Register as an Advertiser</h1>

        <!-- Display success message -->
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Display validation errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Registration form -->
        <form action="{{ route('advertisers.register') }}" method="POST" novalidate>
            @csrf

            <!-- Company and Full Name -->
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="company" class="form-label">Company:</label>
                    <input type="text" name="company" id="company" class="form-control" placeholder="Company Name"
                        value="{{ old('company') }}" required>
                    @error('company')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Full Name"
                        value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"
                    value="{{ old('phone') }}" required>
                @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Address"
                    value="{{ old('address') }}">
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Password and Confirm Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                    required>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                    placeholder="Confirm Password" required>
                @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Status -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select name="status" class="form-select" required>
                        <option disabled @if(old('status') === null) selected @endif>{{ __('Choose...') }}</option>
                        <option value=0 @if(old('status') === 0) selected @endif>{{ __('Pending') }}</option>
                        <option value=1 @if(old('status') === 1) selected @endif>{{ __('Active') }}</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>

        <!-- Sign-in Link -->
        <div class="text-center mt-4">
            <p>Already have an account? <a href="{{ route('login') }}" class="btn btn-link">Sign in</a></p>
        </div>
    </div>

    <!-- Include necessary JS libraries -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
