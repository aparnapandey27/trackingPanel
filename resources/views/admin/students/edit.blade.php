@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('Edit Student') }}</h6>

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
            
            <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="form-group mb-3">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                </div>

                <!-- Email Field -->
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                </div>

                <!-- Phone Field -->
                <div class="form-group mb-3">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone) }}" required>
                </div>

                <!-- Address Field -->
                <div class="form-group mb-3">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $student->address) }}" required>
                </div>

                <!-- Status Dropdown -->
                <div class="form-group mb-4">
                    <label for="status">Status:</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="1" {{ old('status', $student->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $student->status) == 0 ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Student</button>
            </form>
        </div>
    </div>
</div>
@endsection
