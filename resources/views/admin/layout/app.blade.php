<!DOCTYPE html>
@if (\Request::is('rtl'))
  <html dir="rtl" lang="ar">
@else
  <html lang="en">
@endif

<!-- Include the head file -->
@include('layouts.head')

<body class="g-sidenav-show bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }}">

  {{-- <!-- Hamburger Icon Button -->
  <button id="sidebarToggle" class="navbar-toggler" type="button" style="position: absolute; top: 10px; left: 10px; z-index: 1000;">
    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
  </button> --}}

  @include('layouts.navbars.auth.sidebar')
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
    {{-- @include('layouts.header') --}}
      @include('layouts.navbars.auth.nav')
      <div class="container-fluid py-4">
          @yield('content')
          
          <!-- Footer Section -->
          
          <!-- End Footer Section -->
      </div>
      @include('layouts.footers.auth.footer')
      
  </main>
  @include('components.fixed-plugin')

  @if(session()->has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
      <p class="m-0">{{ session('success') }}</p>
    </div>
  @endif

  @include('layouts.script')

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">x</span>
              </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              @if (Session::has('admin_user_id') && session()->has('temp_user_id'))
                  <a class="btn btn-primary" href="{{ route('logoutAs') }}">
                      Logout
                  </a>
              @else
                  <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                          document.getElementById('logout-form-navigation').submit();">
                      Logout
                  </a>

                  <form id="logout-form-navigation" action="{{ route('logout') }}" method="POST"
                      class="d-none">
                      @csrf
                  </form>
              @endif

          </div>
      </div>
  </div>
</div>

</body>

</html>
