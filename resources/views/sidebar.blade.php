<div class="sidebar">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

        @if(auth()->check() && auth()->user()->role == 'admin')
            <li><a href="{{ route('admin.report.performance') }}">Performance Reports</a></li>
            <li><a href="{{ route('admin.offers.create') }}">Create Offer</a></li>
            <li><a href="{{ route('admin.offers.index') }}">Show Offer</a></li>
            <li><a href="{{ route('admin.preference.company') }}">Company Preferences</a></li>
            <li><a href="{{ route('admin.mailroom.index') }}">Mail Room</a></li>
        @endif

        @if(auth()->check() && auth()->user()->role == 'student')
            <li><a href="{{ route('students.add') }}">Add Student</a></li>
            <li><a href="{{ route('students.manage') }}">Manage Students</a></li>
        @endif

        @if(auth()->check() && auth()->user()->role == 'advertiser')
            <li><a href="{{ route('advertisers.add') }}">Add Advertiser</a></li>
            <li><a href="{{ route('advertisers.manage') }}">Manage Advertisers</a></li>
        @endif

        @if(auth()->check() && auth()->user()->role == 'employee')
            <li><a href="{{ route('employees.add') }}">Add Employee</a></li>
            <li><a href="{{ route('employees.manage') }}">Manage Employees</a></li>
        @endif

        @if(auth()->check())
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Sign Out</button>
                </form>
            </li>
        @endif
    </ul>
</div>
