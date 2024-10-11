<!-- Core JS Files -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>



<!-- jQuery -->



<!-- Github Buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages, etc -->
<script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>

@stack('scripts')

<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    };
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }

  // JavaScript for toggling sidebar visibility
  document.getElementById('sidebarToggle').addEventListener('click', function () {
    var body = document.querySelector('body');

    // Toggle the class that controls sidebar visibility
    if (body.classList.contains('g-sidenav-show')) {
      body.classList.remove('g-sidenav-show');
      body.classList.add('g-sidenav-hidden');
    } else {
      body.classList.remove('g-sidenav-hidden');
      body.classList.add('g-sidenav-show');
    }
  });
</script>

