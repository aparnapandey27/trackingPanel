<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('login') }}">   
      <h1 class="ms-3 font-weight-bold" 
    style="font-size: 2rem; 
           font-family: 'Poppins', sans-serif; 
           background: linear-gradient(90deg, #1a73e8, #34a853); 
           -webkit-background-clip: text; 
           color: transparent; 
           text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); 
           letter-spacing: 1px;">
    Festinator
</h1>
    </a>
  </div>
  @php
		$segment1 = request()->segment(1);
		$segment2 = request()->segment(2);
		$segment3 = request()->segment(3);
		$segment4 = request()->segment(4);
	@endphp
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ route('employee.dashboard')}}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <title>shop </title>
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                  <g transform="translate(1716.000000, 291.000000)">
                    <g transform="translate(0.000000, 148.000000)">
                      <path class="color-background opacity-6" d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                      <path class="color-background" d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <li class="nav-item pb-2 {{ (Request::is('employee/report/*') ? 'active' : '') }}">
        <a class="nav-link {{ (Request::is('employee/report/*') ? 'active' : '') }}" href="#" id="reportsLink" onclick="toggleReportsOptions()">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i style="font-size: 1rem;" class="fas fa-lg fa-chart-bar ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
        </a>
        <div id="reportsOptions" style="display: {{ (Request::is('employee/report/*') ? 'block' : 'none') }}; padding-left: 20px;">
          <a class="nav-link {{ (Request::is('employee/report/performance') ? 'active' : '') }}" href="{{ route('employee.report.performance') }}">
              <span class="nav-link-text ms-1">Performance</span>
          </a>
          <a class="nav-link {{ (Request::is('employee/report/conversion') ? 'active' : '') }}" href="{{ route('employee.report.conversion') }}">
              <span class="nav-link-text ms-1">Conversion</span>
          </a>
        </div>
      </li>
      <script>
        document.getElementById('reportsLink').addEventListener('click', function() {
          var options = document.getElementById('reportsOptions');
          if (options.style.display === 'none') {
            options.style.display = 'block';
          } else {
            options.style.display = 'none';
          }
        });
      </script>

      

      <li class="nav-item pb-2">
        <!-- Main Offers Link -->
        <a class="nav-link {{ Request::is('employee/offer*') ? 'active' : '' }}" href="#" id="offersLink">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i style="font-size: 1rem;" class="fas fa-tags ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
        </div>
            <span class="nav-link-text ms-1">Offers</span>
        </a>
        <!-- Submenu with conditional display -->
        <div id="offersOptions" style="display: {{ Request::is('employee/offer*') ? 'block' : 'none' }}; padding-left: 20px;">
            <!-- Create Offer -->
            
            <!-- Manage Offers -->
            <a class="nav-link {{ Request::is('employee/offers') ? 'active' : '' }}" href="{{ route('employee.offer.index') }}">
                <span class="nav-link-text ms-1">Manage</span>
            </a>
            
        </div>
        <script>
            document.getElementById('offersLink').addEventListener('click', function() {
                var options = document.getElementById('offersOptions');
                options.style.display = options.style.display === 'none' ? 'block' : 'none';
            });
        </script>
    </li>

      

      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Users</h6>
      </li>
      <li class="nav-item {{ Request::is('employee/student*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" id="studentLink" data-toggle="collapse" data-target="#studentMenu" aria-expanded="{{ Request::is('admin/student*') ? 'true' : 'false' }}" aria-controls="studentMenu">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-user-graduate ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Student</span>
      </a>
            <div id="studentOptions" style="display: none; padding-left: 20px;">
            <a class="nav-link {{ (Request::is('student/add') ? 'active' : '') }}" href="{{ route('employee.student.create')}}">
              <span class="nav-link-text ms-1">Add</span>
            </a>
            <a class="nav-link {{ (Request::is('student/manage') ? 'active' : '') }}" href="{{ route('employee.student.index') }}">
              <span class="nav-link-text ms-1">Manage</span>
            </a>
            <a class="nav-link {{ (Request::is('student/postbacks') ? 'active' : '') }}" href="{{ route('employee.postback.index') }}">
              <span class="nav-link-text ms-1">Postback</span>
            </a>
            </div>
            <script>
            document.getElementById('studentLink').addEventListener('click', function() {
              var options = document.getElementById('studentOptions');
              if (options.style.display === 'none') {
                  options.style.display = 'block';
              } else {
                  options.style.display = 'none';
              }
            });
            </script>

<li class="nav-item mt-2">
  <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Custom</h6>
</li>
<li class="nav-item">
  <a class="nav-link {{ (Request::is('tables') ? 'active' : '') }}" href="{{ route('employee.conversion.index')}}">
    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
      <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>office</title>
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF" fill-rule="nonzero">
            <g transform="translate(1716.000000, 291.000000)">
              <g id="office" transform="translate(153.000000, 2.000000)">
                <path class="color-background opacity-6" d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"></path>
                <path class="color-background" d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"></path>
              </g>
            </g>
          </g>
        </g>
      </svg>
    </div>
    <span class="nav-link-text ms-1">Import Conversion</span>
  </a>
</li>	

<li class="nav-item">
  <a class="nav-link {{ (Request::is('tables') ? 'active' : '') }}" href="{{ route('employee.account.index')}}">
    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
      <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>office</title>
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF" fill-rule="nonzero">
            <g transform="translate(1716.000000, 291.000000)">
              <g id="office" transform="translate(153.000000, 2.000000)">
                <path class="color-background opacity-6" d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"></path>
                <path class="color-background" d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"></path>
              </g>
            </g>
          </g>
        </g>
      </svg>
    </div>
    <span class="nav-link-text ms-1">My Account</span>
  </a>
</li>	


      <li class="nav-item">
        <a class="nav-link {{ (Request::is('logOut') ? 'active' : '') }}" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>shop </title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(0.000000, 148.000000)">
                                    <path class="color-background opacity-6" d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                    <path class="color-background" d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="nav-link-text ms-1">Log Out</span>
        </a>
    </li>
      
  </div>
</aside>
