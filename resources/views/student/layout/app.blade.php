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

  @include('student.layout.sidebar')
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
      @include('layouts.navbars.auth.nav')
      <div class="container-fluid py-4">
          @yield('content')
          @include('layouts.footers.auth.footer')
      </div>
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

</body>
</html>