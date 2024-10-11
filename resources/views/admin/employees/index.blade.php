@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <h6 class="mb-0">{{ __('Employee Dashboard') }}</h6>
    <div class="card mt-4">
        <div class="card-header pb-0 px-3">
            <h6 class="mb-0">{{ __('Manage Employees') }}</h6>
        </div>
        <div class="card-body pt-4 p-3">
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">Add Employee</a>
            <a href="{{ route('admin.employees.manage') }}" class="btn btn-secondary">Manage employees</a>
        </div>
    </div>
</div>
@endsection
