@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.offices')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.add')</li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.offices.index')}}">@lang('site.offices')</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome')}}">@lang('site.dashboard') <i class="fas fa-tachometer-alt"></i></a></li>
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
            <div class="card card-dark">

                <div class="card-header">
                  <h5 class="card-title">@lang('site.add')</h5>
                </div><!-- end of card header -->

                @include('partials._errors')

                <form action="{{ route('dashboard.offices.store') }}" method="post">

                  {{ csrf_field() }}
                  {{ method_field('post') }}

                  <div class="card-body">

                      <div class="form-group">
                          <label>@lang('site.name')</label>
                          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                      </div>

                    


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> @lang('site.add')</button>
                    </div>
                  </div>
                  <!-- /.card-footer -->

                </form><!-- end of form -->

              </div>
              <!-- /.card -->

          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>

@endsection