@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard v1 <i class="fas fa-tachometer-alt"></i></li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">

            <!-- general form elements -->
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Quick Example</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <h1>Content</h1>
                </div>
                  <!-- /.card-body -->
  
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

              </div>
              <!-- /.card -->

          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>

@endsection