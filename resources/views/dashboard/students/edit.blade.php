@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.students')</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.edit')</li>
                  <li class="breadcrumb-item"><a href="{{ route('dashboard.students.index')}}">@lang('site.students')</a></li>
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

                <form action="{{ route('dashboard.students.update', $student->id) }}" method="post">

                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                  <div class="card-body">

                    <div class="row">
                      <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                          <label>@lang('site.name')</label>
                          <input type="text" name="name" class="form-control" value="{{ $student->name }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.idcard')</label>
                          <input type="number" name="idcard" class="form-control" value="{{ $student->idcard }}">
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
                                <option value="{{ $office->id }}" {{ $student->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
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
                          <label>@lang('site.stage')</label>
                          @php
                            $stages = [trans('site.primary_school'), trans('site.middle_school'), trans('site.secondary_school')];
                          @endphp
                          <select name="stage" id="stage" class="form-control select_size">
                              @foreach ($stages as $stage)
                                  <option value="{{ $stage }}" {{ $student->stage == $stage ? 'selected' : '' }}>{{ $stage }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.class')</label>
                          @php
                          $classes = [
                              trans('site.primary_class1'), trans('site.primary_class2'), trans('site.primary_class3'),
                              trans('site.primary_class4'), trans('site.primary_class5'), trans('site.primary_class6'),
                              trans('site.middle_class1'), trans('site.middle_class2'), trans('site.middle_class3'),
                              trans('site.secondary_class1'), trans('site.secondary_class2'), trans('site.secondary_class3'),
                          ];
                          @endphp
                          <select name="class" id="class" class="form-control select_size">
                              @foreach ($classes as $class)
                                  <option value="{{ $class }}" {{  $student->class == $class ? 'selected' : '' }}>{{ $class }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>@lang('site.email')</label>
                                <input type="email" name="email" class="form-control" value="{{ $student->email }}">
                            </div> 
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>@lang('site.mobile')</label>
                            <input type="number" name="mobile" class="form-control" value="{{  $student->mobile }}">
                          </div>
                        </div>
                    </div>

                    <div class="row">

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.teacher')</label>
                          <select name="teacher_id" id="teacher_id" class="form-control select_size">
                            
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>@lang('site.degree')</label>
                          <input type="number" name="degree" class="form-control" value="{{ $student->degree }}">
                        </div>
                      </div>

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
        // append Schools on office change
        dependentSchools();
        $(document).on('change', '#office_id', function() {
            dependentSchools();
            return false;
        });
        function dependentSchools() {
            $('option', $('#school_id')).remove();
            $('option', $('#teacher_id')).remove();
            var translate = @json( __('site.all_schools') );
            $('#school_id').append($('<option></option>').val('').html(translate));
            var officeIdVal = $('#office_id').val() != null ? $('#office_id').val() : '{{ old('office_id') }}';
            $.get("{{ route('dashboard.get_schools') }}", { office_id: officeIdVal }, function (data) {
                $.each(data, function(val, text) {
                    var selectedVal = val == '{{ $student->school_id }}' ? "selected" : "";
                    $('#school_id').append($('<option ' + selectedVal + '></option>').val(val).html(text));
                })
            }, "json");
        }

        // append Teachers on school change
        dependentTeachers();
        $(document).on('change', '#school_id', function() {
            dependentTeachers();
            return false;
        });
        function dependentTeachers() {
            $('option', $('#teacher_id')).remove();
            var schoolIdVal = $('#school_id').val() != null ? $('#school_id').val() : '{{ old('school_id') }}';
            $.get("{{ route('dashboard.get_teachers') }}", { school_id: schoolIdVal }, function (data) {
                $.each(data, function(val, text) {
                    var selectedVal = val == '{{ $student->teacher_id }}' ? "selected" : "";
                    $('#teacher_id').append($('<option ' + selectedVal + '></option>').val(val).html(text));
                })
            }, "json");
        }

        // append Class on stage change
        dependentStages()
        $(document).on('change', '#stage', function() {
            dependentStages();
            return false;
        });

        function dependentStages() {
          $('option', $('#class')).remove();
          var all_stage = @json( __('site.class') );
          var transStage = all_stage == '{{ $student->class }}' ? "selected" : "";
          $('#class').append($('<option ' + selectedVal + '></option>').val('').html(all_stage));

          //console.log(transStage1 , transStage2 ,transStage3);
          var current_Stage = $('#stage').val();
          switch (current_Stage) {
            case 'ابتدائي':
              var transStage1 = [ @json( __('site.primary_class1') ) , @json( __('site.primary_class2') ), @json( __('site.primary_class3') ),
                                  @json( __('site.primary_class4') ) , @json( __('site.primary_class5') ), @json( __('site.primary_class6') )];
              
              var classLen = transStage1.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage1[i] == '{{ $student->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage1[i]).html(transStage1[i]));
              }
              break;
            case 'متوسط':
              var transStage2 = [ @json( __('site.middle_class1') ) , @json( __('site.middle_class2') ), @json( __('site.middle_class3') )];

              var classLen = transStage2.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage2[i] == '{{ $student->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage2[i]).html(transStage2[i]));
              }
              break;
            case 'ثانوي':
              var transStage3 = [ @json( __('site.secondary_class1') ) , @json( __('site.secondary_class2') ), @json( __('site.secondary_class3') )];

              var classLen = transStage3.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage3[i] == '{{ $student->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage3[i]).html(transStage3[i]));
              }
              break;
            default:
              var transStage = [ @json( __('site.primary_class1') ) , @json( __('site.primary_class2') ), @json( __('site.primary_class3') ),
                                  @json( __('site.primary_class4') ) , @json( __('site.primary_class5') ), @json( __('site.primary_class6') ),
                                  @json( __('site.middle_class1') ) , @json( __('site.middle_class2') ), @json( __('site.middle_class3') ),
                                  @json( __('site.secondary_class1') ) , @json( __('site.secondary_class2') ), @json( __('site.secondary_class3') )];

              var classLen = transStage.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage[i] == '{{ $student->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage[i]).html(transStage[i]));
              }
          }
        }
       
    });    
  </script>
    
@endsection