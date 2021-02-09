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
              
              <div class="card-body">
                <form action="{{ route('dashboard.students.update', $student->id) }}" method="post">

                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

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
                                <option value="{{ $class }}" {{ $student->class == $class ? 'selected' : '' }}>{{ $class }}</option>
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
                          <input type="number" name="mobile" class="form-control" pattern="^([0-9]+([\.][0-9]+)?)|([\u0660-\u0669]+([\.][\u0660-\u0669]+)?)$" value="{{  $student->mobile }}">
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
                        <input type="number" name="degree" class="form-control" pattern="^([0-9]+([\.][0-9]+)?)|([\u0660-\u0669]+([\.][\u0660-\u0669]+)?)$" value="{{ $student->degree }}">
                      </div>
                    </div>
                  </div>

                  {{-- <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>@lang('site.programs')</label>
                        <select name="program_id[]" id="program_id" class="form-control select_size" multiple>
                          @foreach ($programs as $program)
                            <option value="{{ $program->id }}" {{ $student->programs->contains($program->id) ? 'selected' : '' }}>{{ $program->name }}</option>
                          @endforeach
                        </select>
                        <select name="date[]" id="program_id" class="form-control select_size">
                          @foreach(range(date('Y')-10, date('Y')) as $y)
                            <option value="{{ $y }}">{{ Alkoumi\LaravelHijriDate\Hijri::Date('Y', $y) }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>@lang('site.courses')</label>
                        <select name="course_id[]" id="course_id" class="form-control select_size" multiple>
                          @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ $student->courses->contains($course->id) ? 'selected' : '' }}>{{ $course->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div> --}}

                  {{-- <div class="card-footer">
                    <div class="form-group"> --}}
                      <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> @lang('site.edit')</button>
                    {{-- </div>
                  </div> --}}
                  <!-- /.card-footer -->                    

                </form><!-- end of form -->

                <hr>


                <div class="row">
                  <div class="col-sm-6">
                    <div class="card card-info">
                      <div class="card-header">
                        @lang('site.programs')
                      </div>
                      <div class="card-body">
                        <form action="{{ route('dashboard.students.programs.store', $student->id) }}" method="post">
                          @csrf
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>@lang('site.programs')</label>
                                <select name="program_id" id="program_id" class="form-control select_size">
                                  @foreach ($programs as $program)
                                      <option value="{{ $program->id }}">{{ $program->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>@lang('site.program_date')</label>
                                <input type='text' name="program_date" class="form-control hijri-date-input" />      
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label>@lang('site.note')</label>
                            <textarea name="program_note" cols="20" rows="4" class="form-control"></textarea>
                          </div>

                          <div class="form-group">
                            <label><input name="program_status" type="checkbox" value="1"> @lang('site.status')</label>
                          </div>                 


                      </div>
                      <div class="card-footer">
                        <div class="form-group">
                          <button type="submit" class="btn btn-info"><i class="fas fa-edit"></i> @lang('site.create')</button>
                        </div>   
                      </div> 
                    </form>                     
                    </div>  

                    @if($student->programs->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-striped text-center" dir="rtl">
                            <thead>
                                <tr class="bg-info">
                                    <th>#</th>
                                    <th>@lang('site.programs')</th>
                                    <th>@lang('site.program_date')</th>
                                    <th>@lang('site.note')</th>
                                    <th>@lang('site.status')</th>
                                    <th width="10%" colspan="2" class="text-center">@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->programs as $program)
                                  <tr class="text-center text-bold">
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $program->name }}</td>
                                      <td>{{ $program->pivot->program_date }}</td>
                                      <td class="text-justify text-center">{{ $program->pivot->program_note }}</td>
                                      <td>
                                        @if ($program->pivot->program_status == 1)
                                          <i class="fas fa-check-circle text-success"></i>
                                        @else
                                          <i class="fas fa-times-circle text-danger"></i>
                                        @endif                             
                                      </td>

                                      <td>
                                        @if (auth()->user()->hasPermission('students_update'))
                                            <a href="{{ route('dashboard.students.programs.edit', [$student->id, $program->pivot->id] ) }}" class="btn btn-info btn-sm"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="@lang('site.edit')"></i></a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                    </td>

                                    <td>
                                      @if (auth()->user()->hasPermission('students_delete'))
                                          <form action="{{ route('dashboard.students.programs.destroy', [$student->id, $program->pivot->id]) }}" method="post" style="display: inline-block">
                                              {{ csrf_field() }}
                                              {{ method_field('delete') }}
                                              <button type="submit" class="btn btn-danger delete btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.delete')"><i class="fa fa-trash"></i></button>
                                          </form><!-- end of form -->
                                        @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        @endif
                                    </td>
      
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>  
                    @endif
                                    
                  </div>

                  <div class="col-sm-6">
                    <div class="card card-info">
                      <div class="card-header">
                        @lang('site.courses')
                      </div>
                      <div class="card-body">
                        <form action="{{ route('dashboard.students.update', $student->id) }}" method="post">

                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>@lang('site.courses')</label>
                                <select name="course_id" id="course_id" class="form-control select_size">
                                  @foreach ($courses as $course)
                                      <option value="{{ $course->id }}">{{ $course->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>@lang('site.course_date')</label>
                                <input type='text' name="course_date" class="form-control hijri-date-input" />      
                              </div>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label>@lang('site.note')</label>
                            <textarea name="course_note" cols="20" rows="4" class="form-control"></textarea>
                          </div>

                          <div class="form-group">
                            <label><input name="course_status" type="checkbox" value="1"> @lang('site.status')</label>
                          </div>
                                            
                        </form>
                      </div>
                      <div class="card-footer">
                        <div class="form-group">
                          <button type="submit" class="btn btn-info"><i class="fas fa-edit"></i> @lang('site.create')</button>
                        </div>   
                      </div>
                    </div>  
                    
                    @if($student->courses->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-striped text-center" dir="rtl">
                            <thead>
                                <tr class="bg-info">
                                    <th>#</th>
                                    <th>@lang('site.courses')</th>
                                    <th>@lang('site.course_date')</th>
                                    <th>@lang('site.note')</th>
                                    <th>@lang('site.status')</th>
                                    <th width="10%" colspan="2" class="text-center">@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->courses as $course)
                                  <tr class="text-center text-bold">
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $course->name }}</td>
                                      <td>{{ $course->pivot->course_date }}</td>
                                      {{-- <td>{{ Carbon\Carbon::createFromTimestamp($course->course_date)->year  }}</td> --}}
                                      <td class="text-justify text-center">{{ $course->pivot->course_note }}</td>
                                      <td>
                                          @if ($course->pivot->course_status == 1)
                                            <i class="fas fa-check-circle text-success"></i>
                                          @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                          @endif
                                      </td>

                                      <td>
                                        @if (auth()->user()->hasPermission('students_update'))
                                            <a href="{{ route('dashboard.students.edit', $student->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="@lang('site.edit')"></i></a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                    </td>
                                    
                                    <td>
                                      @if (auth()->user()->hasPermission('students_delete'))
                                            <form action="{{ route('dashboard.students.destroy', $student->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.delete')"><i class="fa fa-trash"></i></button>
                                            </form><!-- end of form -->
                                        @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        @endif
                                    </td>
      
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>   
                    @endif

                  </div>
                </div>
              </div>
              <!-- /.card-body -->
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
                    var selectedVal = text == '{{ $student->school_id }}' ? "selected" : "";
                    $('#school_id').append($('<option ' + selectedVal + '></option>').val(text).html(val));
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