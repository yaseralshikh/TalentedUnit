@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.teachers')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.edit')</li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.teachers.index')}}">@lang('site.teachers')</a></li>
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

                <form action="{{ route('dashboard.teachers.update', $teacher->id) }}" method="post" enctype="multipart/form-data">

                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.name')</label>
                          <input type="text" name="name" class="form-control" value="{{ $teacher->name }}">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.idcard')</label>
                          <input type="number" name="idcard" class="form-control" value="{{ $teacher->idcard }}">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.office')</label>
                          <select name="office_id" id="office_id" class="form-control select_size">
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ $teacher->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.school')</label>
                          <select name="school_id" id="school_id" class="form-control select_size">

                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          @php
                            $specializations = [trans('site.religion'), trans('site.quran'), trans('site.sciences')
                                              , trans('site.mathematics'), trans('site.miology'), trans('site.chemistry')
                                              , trans('site.physics'), trans('site.social_studies'), trans('site.art')
                                              , trans('site.Physical'), trans('site.english'), trans('site.psychology')
                                              , trans('site.computer'), trans('site.arabic_language'), trans('site.other')];
                          @endphp

                          <label>@lang('site.specialization')</label>
                          <select name="specialization" class="form-control select_size">
                            @foreach ($specializations as $specialization)
                              <option value="{{ $specialization }}" {{ $teacher->specialization == $specialization ? 'selected' : '' }}>{{ $specialization }}</option>  
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.mobile')</label>
                          <input type="number" name="mobile" class="form-control" value="{{ $teacher->mobile }}">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>@lang('site.email')</label>
                      <input type="email" name="email" class="form-control" value="{{  $teacher->email }}">
                    </div>

                    <div class="form-group">
                      <label>@lang('site.image')</label>
                      <input type="file" name="image" class="form-control image">
                      <small id="banner_imageHelp" class="form-text text-muted">@lang('site.image_attributes')</small>
                    </div>

                    <div class="form-group">
                        <img src="{{ $teacher->image_path }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
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

@section('scripts')

  <script>
    $(function () {
        dependentSchools();
        $(document).on('change', '#office_id', function() {
            dependentSchools();
            return false;
        });
        function dependentSchools() {
            $('option', $('#school_id')).remove();
            var officeIdVal = $('#office_id').val() != null ? $('#office_id').val() : '{{ old('office_id') }}';
            $.get("{{ route('dashboard.get_schools') }}", { office_id: officeIdVal }, function (data) {
                $.each(data, function(val, text) {
                    var selectedVal = text == '{{ $teacher->school_id }}' ? "selected" : "";
                    $('#school_id').append($('<option ' + selectedVal + '></option>').val(text).html(val));
                })
            }, "json");
        }
    });    
  </script>
    
@endsection