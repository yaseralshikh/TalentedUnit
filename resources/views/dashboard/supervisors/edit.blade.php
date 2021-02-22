@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.supervisors')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.edit')</li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.supervisors.index')}}">@lang('site.supervisors')</a></li>
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

                <form action="{{ route('dashboard.supervisors.update', $user->id) }}" method="post" enctype="multipart/form-data">

                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.name')</label>
                          <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.idcard')</label>
                          <input type="number" name="idcard" class="form-control" value="{{ $user->idcard }}">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.mobile')</label>
                          <input type="number" name="mobile" class="form-control" value="{{ $user->mobile }}">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.email')</label>
                          <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.office')</label>
                          <select name="office_id" id="office_id" class="form-control select_size">
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ $user->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.image')</label>
                          <input type="file" name="image" class="form-control image">
                        </div>

                        <div class="form-group">
                          <img src="{{ $user->image_path }}"  style="width: 100px" class="img-thumbnail image-preview" alt="">
                      </div> 
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.password')</label>
                          <input type="password" name="password" class="form-control">
                          <small id="PasswordHelp" class="form-text text-muted">@lang('site.passwordHelp')</small>
                      </div>

                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.password_confirmation')</label>
                          <input type="password" name="password_confirmation" class="form-control">
                          <small id="PasswordHelp" class="form-text text-muted">@lang('site.passwordHelp')</small>
                      </div>
                      </div>
                    </div>

                    <div class="form-group mt-3">
                      <div class="card">
                        <div class="card-header p-2">
                          <label>@lang('site.permissions')</label>

                          @php
                              $models = ['offices', 'schools', 'teachers', 'students','programs', 'courses', 'supervisors'];
                              $maps = ['create', 'read', 'update', 'delete', 'import', 'export'];
                          @endphp

                          <ul class="nav nav-tabs">
                            @foreach ($models as $index=>$model)
                              <li class="nav-item"><a class="nav-link {{ $index == 0 ? 'active' : '' }}" href="#{{ $model }}" data-toggle="tab">@lang('site.' . $model)</a></li>
                            @endforeach
                          </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                          <div class="tab-content">
                            @foreach ($models as $index=>$model)
                              <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                @foreach ($maps as $map)
                                  <label class="ml-3"><input type="checkbox" name="permissions[]" {{ $user->hasPermission( $model . '_' . $map ) ? 'checked' : '' }} value="{{ $model . '_' . $map }}"> @lang('site.' . $map)</label>
                                @endforeach
                                <!-- /.post -->
                              </div>
                              <!-- /.tab-pane -->
                            @endforeach
                          </div>
                          <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                      </div>
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