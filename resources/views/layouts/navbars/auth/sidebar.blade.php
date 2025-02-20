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
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ route('admin.dashboard')}}">
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
      <li class="nav-item pb-2 {{ (Request::is('admin/report/*') ? 'active' : '') }}">
        <a class="nav-link {{ (Request::is('admin/report/*') ? 'active' : '') }}" href="#" id="reportsLink" onclick="toggleReportsOptions()">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i style="font-size: 1rem;" class="fas fa-lg fa-chart-bar ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
        </a>
        <!-- Dropdown for Reports -->
        <div id="reportsOptions" style="display: {{ (Request::is('admin/report/*') ? 'block' : 'none') }}; padding-left: 20px;">
          <a class="nav-link {{ (Request::is('admin/report/performance') ? 'active' : '') }}" href="{{ route('admin.report.performance') }}">
              <span class="nav-link-text ms-1">Performance</span>
          </a>
          <a class="nav-link {{ (Request::is('admin/report/conversion') ? 'active' : '') }}" href="{{ route('admin.report.conversion') }}">
              <span class="nav-link-text ms-1">Conversion</span>
          </a>
          <a class="nav-link {{ (Request::is('admin/report/conversion/log') ? 'active' : '') }}" href="{{ route('admin.report.conversion.log') }}">
              <span class="nav-link-text ms-1">Conversion Logs</span>
          </a>
          <a class="nav-link {{ (Request::is('admin/report/click/log') ? 'active' : '') }}" href="{{ route('admin.report.click.log') }}">
              <span class="nav-link-text ms-1">Click Logs</span>
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
      </li>
      <li class="nav-item pb-2">
        <!-- Main Offers Link -->
        <a class="nav-link {{ Request::is('admin/offers*') ? 'active' : '' }}" href="#" id="offersLink">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i style="font-size: 1rem;" class="fas fa-tags ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
        </div>
          <span class="nav-link-text ms-1">Offers</span>
      </a>      
        <!-- Submenu with conditional display -->
        <div id="offersOptions" style="display: {{ Request::is('admin/offers*') ? 'block' : 'none' }}; padding-left: 20px;">
            <!-- Create Offer -->
            <a class="nav-link {{ Request::is('admin/offers/create') ? 'active' : '' }}" href="{{ route('admin.offers.create') }}">
                <span class="nav-link-text ms-1">Create</span>
            </a>
            <!-- Manage Offers -->
            <a class="nav-link {{ Request::is('admin/offers') ? 'active' : '' }}" href="{{ route('admin.offers.index') }}">
                <span class="nav-link-text ms-1">Manage</span>
            </a>
            <!-- Offer Categories -->
            <a class="nav-link {{ Request::is('admin/offers/categories') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <span class="nav-link-text ms-1">Offer Categories</span>
            </a>
            <!-- Offer Application -->
            <a class="nav-link {{ Request::is('admin/offers/offerApplication') ? 'active' : '' }}" href="{{ route('admin.offerApplication.index') }}">
                <span class="nav-link-text ms-1">Offer Application</span>
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
      <li class="nav-item {{ Request::is('admin/student*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" id="studentLink" data-toggle="collapse" data-target="#studentMenu" aria-expanded="{{ Request::is('admin/student*') ? 'true' : 'false' }}" aria-controls="studentMenu">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-user-graduate ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Student</span>
      </a>
      
            <div id="studentOptions" style="display: none; padding-left: 20px;">
            <a class="nav-link {{ (Request::is('student/add') ? 'active' : '') }}" href="{{ route('admin.students.create')}}">
              <span class="nav-link-text ms-1">Add</span>
            </a>
            <a class="nav-link {{ (Request::is('student/manage') ? 'active' : '') }}" href="{{ route('admin.students.manage') }}">
              <span class="nav-link-text ms-1">Manage</span>
            </a>
            <a class="nav-link {{ (Request::is('student/postbacks') ? 'active' : '') }}" href="{{ route('admin.postback.index') }}">
              <span class="nav-link-text ms-1">Postback</span>
            </a>
            <a class="nav-link {{ (Request::is('student/payments') ? 'active' : '') }}" href="{{ route('admin.payment.index') }}">
              <span class="nav-link-text ms-1">Payment</span>
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
      <li class="nav-item pb-2">
        <a class="nav-link" href="#" id="advertiserLink">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i style="font-size: 1rem;" class="fas fa-handshake ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Advertiser</span>
      </a>
      
        <div id="advertiserOptions" style="display: none; padding-left: 20px;">
        <a class="nav-link {{ (Request::is('advertiser/add') ? 'active' : '') }}" href="{{ route('admin.advertisers.create')}}">
          <span class="nav-link-text ms-1">Add</span>
        </a>
        <a class="nav-link {{ (Request::is('advertiser/manage') ? 'active' : '') }}" href="{{ route('admin.advertisers.manage')}}">
        <span class="nav-link-text ms-1">Manage</span>
        </a>
    </div>
    <script>
      document.getElementById('advertiserLink').addEventListener('click', function() {
          var options = document.getElementById('advertiserOptions');
            if (options.style.display === 'none') {
                options.style.display = 'block';
            } else {
                options.style.display = 'none';
            }
      });
    </script>
    </a>
</li>
      <li class="nav-item pb-2">
        <a class="nav-link" href="#" id="employeeLink">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i style="font-size: 1rem;" class="fas fa-user-tie ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
          </div>
          <span class="nav-link-text ms-1">Employee</span>
      </a>      
      <div id="employeeOptions" style="display: none; padding-left: 20px;">
      <a class="nav-link {{ (Request::is('employee/add') ? 'active' : '') }}" href="{{ route('admin.employees.create')}}">
        <span class="nav-link-text ms-1">Add</span>
      </a>
      <a class="nav-link {{ (Request::is('employee/manage') ? 'active' : '') }}" href="{{ route('admin.employees.manage')}}">
        <span class="nav-link-text ms-1">Manage</span>
      </a>
      </div>
      <script>
      document.getElementById('employeeLink').addEventListener('click', function() {
        var options = document.getElementById('employeeOptions');
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
        <a class="nav-link {{ (Request::is('tables') ? 'active' : '') }}" href="{{ route('admin.conversion.index')}}">
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
      
    <li class="nav-item pb-2">
      <a class="nav-link" href="#" id="ipwhitelistingLink">
        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i style="font-size: 1rem;" class="fas fa-user-tie ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
        </div>
        <span class="nav-link-text ms-1">IP Whitelisting</span>
    </a>      
    <div id="Options" style="display: none; padding-left: 20px;">
    <a class="nav-link {{ (Request::is('ip/add') ? 'active' : '') }}" href="{{ route('admin.ip.create')}}">
      <span class="nav-link-text ms-1">Add</span>
    </a>
    <a class="nav-link {{ (Request::is('ip/manage') ? 'active' : '') }}" href="{{ route('admin.ip.index')}}">
      <span class="nav-link-text ms-1">Manage</span>
    </a>
    </div>
    <script>
    document.getElementById('ipwhitelistingLink').addEventListener('click', function() {
      var options = document.getElementById('Options');
      if (options.style.display === 'none') {
          options.style.display = 'block';
      } else {
          options.style.display = 'none';
      }
    });
    </script>
    
    <li class="nav-item">
      <a class="nav-link {{ (Request::is('admin/mailroom') ? 'active' : '') }}" href="{{ route('admin.mailroom.index') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <title>mail-icon</title>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                          <g transform="translate(1716.000000, 291.000000)">
                              <g transform="translate(603.000000, 0.000000)">
                                  <path class="color-background" d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"></path>
                                  <path class="color-background opacity-6" d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"></path>
                                  <path class="color-background opacity-6" d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"></path>
                              </g>
                          </g>
                      </g>
                  </g>
              </svg>
          </div>
          <span class="nav-link-text ms-1">Mail Room</span>
      </a>
  </li>
  <li class="nav-item {{ Request::is('admin/preference*') ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" id="preferenceLink" data-toggle="collapse" data-target="#preferenceMenu" aria-expanded="true" aria-controls="preferenceMenu" onclick="togglePreferenceOptions()">
      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
          <i style="font-size: 1rem;" class="fas fa-cogs ps-2 pe-2 text-center text-dark" aria-hidden="true"></i>
      </div>
      <span class="nav-link-text ms-1">Preference</span>
  </a>
    <div id="preferenceMenu" class="collapse {{ Request::is('admin/preference*') ? 'show' : '' }}" style="padding-left: 20px;">
        <a class="nav-link {{ Request::is('admin/preference/company') ? 'active' : '' }}" href="{{ route('admin.preference.company') }}">
            <span class="nav-link-text ms-1">Company</span>
        </a>
        <a class="nav-link {{ Request::is('admin/preference/mail') ? 'active' : '' }}" href="{{ route('admin.preference.mail') }}">
            <span class="nav-link-text ms-1">Email</span>
        </a>
        <a class="nav-link {{ Request::is('admin/preference/paymentOption*') ? 'active' : '' }}" href="{{ route('admin.preference.paymentOption.index') }}">
            <span class="nav-link-text ms-1">Payment Methods</span>
        </a>
        <a class="nav-link {{ Request::is('admin/preference/additional_question') ? 'active' : '' }}" href="{{ route('admin.preference.additional_question') }}">
            <span class="nav-link-text ms-1">Signup Questions</span>
        </a>
    </div>
</li>
    <script>
     function togglePreferenceOptions() {
        var preferenceMenu = document.getElementById('preferenceMenu');
        if (preferenceMenu.classList.contains('collapse')) {
            preferenceMenu.classList.remove('collapse');
            preferenceMenu.classList.add('show');
        } else {
            preferenceMenu.classList.remove('show');
            preferenceMenu.classList.add('collapse');
        }
     } 
    document.getElementById('preferenceLink').addEventListener('click', function() {
      var options = document.getElementById('preferenceOptions');
      if (options.style.display === 'none') {
          options.style.display = 'block';
      } else {
          options.style.display = 'none';
      }
    });
    </script> 
      <li class="nav-item">
        <a class="nav-link " href="{{ route('admin.send.daily.mail') }}">
          <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="20px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <title>spaceship</title>
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                  <g transform="translate(1716.000000, 291.000000)">
                    <g transform="translate(4.000000, 301.000000)">
                      <path class="color-background" d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z"></path>
                      <path class="color-background opacity-6" d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z"></path>
                      <path class="color-background opacity-6" d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z"></path>
                      <path class="color-background opacity-6" d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z"></path>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">Send Report</span>
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
