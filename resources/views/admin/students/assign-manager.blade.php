@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Manager to {{ $student->name }}</h1>

    <form action="{{ route('admin.students.updateManager', $student->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="manager_id">Select Manager</label>
            <select id="manager_id" name="manager_id" class="form-control" required>
                <option value="">-- Select a Manager --</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                @endforeach
            </select>
            @error('manager_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Assign Manager</button>
    </form>
</div>
@endsection
