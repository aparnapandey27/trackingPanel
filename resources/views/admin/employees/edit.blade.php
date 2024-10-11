@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('Edit employee') }}</h6>

    <div class="card">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="form-group mb-3">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                </div>

                <!-- Email Field -->
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                </div>

                <!-- Phone Field -->
                <div class="form-group mb-3">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                </div>

                <!-- Address Field -->
                <div class="form-group mb-3">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $employee->address) }}" required>
                </div>

                <!-- Status Dropdown -->
                <div class="form-group mb-4">
                    <label for="status">Status:</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="1" {{ old('status', $employee->status) == '1' ? 'selected' : '' }}>1</option>
                        <option value="0" {{ old('status', $employee->status) == '0' ? 'selected' : '' }}>0</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update employee</button>

            </form>
        </div>
    </div>
</div>
@endsection
