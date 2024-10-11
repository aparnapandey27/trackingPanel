<header id="page-topbar">
	<div class="layout-width">
		<div class="navbar-header">
			<div class="d-flex">
				<!-- LOGO -->

				<button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
					<span class="hamburger-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</button>
				
				{{-- <!-- Hamburger Icon Button -->
				<button id="sidebarToggle" class="navbar-toggler" type="button" style="position: absolute; top: 10px; left: 10px; z-index: 1000;">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
				</button> --}}

				<div class="navbar-brand-box horizontal-logo">
					<a href="index.html" class="logo logo-dark">
						<span class="logo-sm">
							<img src="{{ asset('assets/images/logo.svg')}}" alt="" height="22">
						</span>
						<span class="logo-lg">
							<img src="{{ asset('assets/images/logo_dark.svg')}}" alt="" height="17">
						</span>
					</a>
					<a href="index.html" class="logo logo-light">
						<span class="logo-sm">
							<img src="{{ asset('assets/images/logo.svg')}}" alt="" height="22">
						</span>
						<span class="logo-lg">
							<img src="{{ asset('assets/images/logo_light.svg')}}" alt="" height="17">
						</span>
					</a>
				</div>
				<button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
					<span class="hamburger-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</button>
				<!-- App Search-->
				<form class="app-search d-none d-md-block">
					<div class="position-relative">
						<input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
						<span class="mdi mdi-magnify search-widget-icon"></span>
						<span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
					</div>
				</form>
			</div>
			<div class="d-flex align-items-center">
				<div class="dropdown d-md-none topbar-head-dropdown header-item">
					<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="bx bx-search fs-22"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
						<form class="p-3">
							<div class="form-group m-0">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
									<button class="btn btn-primary" type="submit">
										<i class="mdi mdi-magnify"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="dropdown ms-1 topbar-head-dropdown header-item">
					<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img id="header-lang-img" src="{{ asset('assets/images/flags/us.svg')}}" alt="Header Language" height="20" class="rounded">
					</button>
					<div class="dropdown-menu dropdown-menu-end">
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
							<img src="{{ asset('assets/images/flags/us.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">English</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
							<img src="{{ asset('assets/images/flags/spain.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">Española</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr" title="German">
							<img src="{{ asset('assets/images/flags/germany.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">Deutsche</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it" title="Italian">
							<img src="{{ asset('assets/images/flags/italy.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">Italiana</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
							<img src="{{ asset('assets/images/flags/russia.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">русский</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
							<img src="{{ asset('assets/images/flags/china.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">中国人</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="fr" title="French">
							<img src="{{ asset('assets/images/flags/french.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">français</span>
						</a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ar" title="Arabic">
							<img src="{{ asset('assets/images/flags/ae.svg')}}" alt="user-image" class="me-2 rounded" height="18">
							<span class="align-middle">Arabic</span>
						</a>
					</div>
				</div>
				
				<div class="ms-1 header-item d-none d-sm-flex">
					<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
						<i class='bx bx-fullscreen fs-22'></i>
					</button>
				</div>
				<div class="dropdown ms-sm-3 header-item topbar-user">
					<button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="d-flex align-items-center">
							<img class="rounded-circle header-profile-user"
                    			src="{{ auth()->user()->profile_photo != null? asset('storage/users/' . auth()->user()->profile_photo): asset('assets/images/noimage.png')}}" alt="user profile">							
							<span class="text-start ms-xl-2">
								<span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
								<span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Admin</span>
							</span>
						</span>
					</button>
					<div class="dropdown-menu dropdown-menu-end">
						<!-- item-->
						<h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
						<a class="dropdown-item" href="{{ route('admin.account.index') }}">
							<i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
							<span class="align-middle">Profile</span>
						</a>						
						<form id="logout-form" action="{{ route('logoutAs') }}" method="POST" style="display: none;">
							@csrf
						</form>
						<!-- Logout Button -->
						<a href="{{ route('logoutAs') }}" class="nav-link text-body font-weight-bold px-0"
						   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="fa fa-user me-sm-1"></i>
							<span class="d-sm-inline d-none">Log Out</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">

</div>
