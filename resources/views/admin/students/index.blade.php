{{-- @extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('Student Dashboard') }}</h6>
    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('Manage Students') }}</h6>
        </div>
        <div class="card-body pt-4 p-3">
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">Add Student</a>
            <a href="{{ route('admin.students.manage') }}" class="btn btn-secondary">Manage Students</a>
        </div>
    </div>
</div>
@endsection --}}


@extends('admin.layout.app')

@section('content')
<div class="container">
    <h2>Students</h2>
    @if(auth()->user()->isAdmin)  
        <div class="mb-3">
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">Add Student</a>
            <a href="{{ route('admin.students.manage') }}" class="btn btn-secondary">Manage Students</a>
        </div>
    @endif
    <table id="studentTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Enrolled Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->created_at }}</td>
                <td>
                    @if(auth()->user()->isAdmin)  <!-- Check if the user is an admin -->
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#studentTable').DataTable();
});
</script>
@endsection
