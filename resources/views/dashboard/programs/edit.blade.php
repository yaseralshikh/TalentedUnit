@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.programs')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.edit')</li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.programs.index')}}">@lang('site.programs')</a></li>
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
            <div class="card card-info">

                <div class="card-header">
                  <h5 class="card-title">@lang('site.edit')</h5>
                </div><!-- end of card header -->

                @include('partials._errors')

                <form action="{{ route('dashboard.programs.update', $program->id) }}" method="post">

                  {{ csrf_field() }}
                  {{ method_field('put') }}

                  <div class="card-body">

                      <div class="form-group">
                          <label>@lang('site.name')</label>
                          <input type="text" name="name" class="form-control" value="{{ $program->name }}">
                      </div>

                      <div class="form-group">
                        <label>@lang('site.description')</label>
                        <textarea name="description" class="form-control" rows="4" cols="50">{{ $program->description }}</textarea>
                      </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> @lang('site.edit')</button>
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