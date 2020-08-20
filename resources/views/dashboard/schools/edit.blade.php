@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.schools')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.edit')</li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.schools.index')}}">@lang('site.schools')</a></li>
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

                <form action="{{ route('dashboard.schools.update', $school->id) }}" method="post">

                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.name')</label>
                          <input type="text" name="name" class="form-control" value="{{ $school->name }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.moeid')</label>
                          <input type="number" name="moe_id" class="form-control" value="{{ $school->moe_id }}">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.office')</label>
                          <select name="office_id" class="form-control">
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ $school->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.stage')</label>
                          @php
                            $stages = [trans('site.primary_school'), trans('site.middle_school'), trans('site.secondary_school')];
                          @endphp
                          <select name="stage" class="form-control">
                            @foreach ($stages as $stage)
                              <option value="{{ $stage }}" {{ $school->stage == $stage ? 'selected' : '' }}>{{ $stage }}</option>  
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.manager')</label>
                          <input type="text" name="manager" class="form-control" value="{{ $school->manager }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.mobile')</label>
                          <input type="number" name="mobile" class="form-control" value="{{ $school->mobile }}">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>@lang('site.email')</label>
                      <input type="email" name="email" class="form-control" value="{{$school->email }}">
                    </div>

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> @lang('site.edit')</button>
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