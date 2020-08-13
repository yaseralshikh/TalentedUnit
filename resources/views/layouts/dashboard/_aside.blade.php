<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link bg-primary">
    <img src="{{ asset( auth()->user()->image_path ) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('dashboard.welcome') }}" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              @lang('site.dashboard')
            </p>
          </a>
        </li>

        @if (auth()->user()->hasPermission('offices_read'))
          <li class="nav-item">
            <a href="{{ route('dashboard.offices.index') }}" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                @lang('site.offices')
              </p>
            </a>
          </li>
        @endif

        @if (auth()->user()->hasPermission('schools_read'))
          <li class="nav-item">
            <a href="{{ route('dashboard.schools.index') }}" class="nav-link">
              <i class="nav-icon fas fa-school"></i>
              <p>
                @lang('site.schools')
              </p>
            </a>
          </li>
        @endif

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>