<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link bg-primary">
    <img src="{{ asset( auth()->user()->image_path ) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar dashboard welcome -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="{{ route('dashboard.welcome') }}" class="d-block pr-3"><i class="nav-icon fas fa-home"></i> @lang('site.dashboard')</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->

        <!-- Sidebar offices -->
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

        <!-- Sidebar schools -->
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

        <!-- Sidebar teachers -->
        @if (auth()->user()->hasPermission('teachers_read'))
          <li class="nav-item">
            <a href="{{ route('dashboard.teachers.index') }}" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                @lang('site.teachers')
              </p>
            </a>
          </li>
        @endif

        <!-- Sidebar students -->
        @if (auth()->user()->hasPermission('students_read'))
          <li class="nav-item">
            <a href="{{ route('dashboard.students.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                @lang('site.students')
              </p>
            </a>
          </li>
        @endif

        <!-- Sidebar supervisors -->
        @if (auth()->user()->hasPermission('supervisors_read'))
          <li class="nav-item">
            <a href="{{ route('dashboard.supervisors.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>
                @lang('site.supervisors')
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