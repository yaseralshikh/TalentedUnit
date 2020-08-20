@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.dashboard')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.dashboard')  <i class="fas fa-tachometer-alt"></i></li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">

            <!-- Small boxes (Stat box) -->
            <div class="row">

              <!-- Offices -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $offices_count }}</h3>

                    <p>@lang('site.offices')</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-building"></i>
                  </div>
                  <a href="{{ route('dashboard.offices.index') }}" class="small-box-footer">@lang('site.read') <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              <!-- Schools -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $schools_count }}</h3>

                    <p>@lang('site.schools')</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-school"></i>
                  </div>
                  <a href="{{ route('dashboard.schools.index') }}" class="small-box-footer">@lang('site.read') <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              <!-- Teachers -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $teachers_count }}</h3>

                    <p>@lang('site.teachers')</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                  </div>
                  <a href="{{ route('dashboard.teachers.index') }}" class="small-box-footer">@lang('site.read') <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              <!-- Students -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-primary">
                  <div class="inner">
                    <h3>{{ $students_count }}</h3>

                    <p>@lang('site.students')</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                  </div>
                  <a href="{{ route('dashboard.students.index') }}" class="small-box-footer">@lang('site.read') <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              <!-- Admin Users -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $users_count }}</h3>

                    <p>@lang('site.users')</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-plus"></i>
                  </div>
                  <a href="#" class="small-box-footer">@lang('site.read') <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

            </div>
            <!-- /.row -->            

          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>

@endsection