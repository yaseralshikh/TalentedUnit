<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link bg-primary">
    <img src="{{ asset( auth()->user()->image_path ) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>

        @if (auth()->user()->hasPermission('users_read'))
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-building"></i>
            <p>
              @lang('site.offices')
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