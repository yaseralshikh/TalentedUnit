@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.students') <small>( {{ $students->total() }} )</small></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.students')</li>
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
            <div class="card card-light" style="border-top: 5px solid rgb(139, 198, 246);">

                <form class="m-3" action="{{ route('dashboard.students.index') }}" method="get">

                  <div class="row">

                      <div class="col-md-4">
                          <input type="text" name="search" id="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                          <small id="studentsSearchHelp" class="form-text text-muted pb-3">@lang('site.studentsSearchHelp')</small>
                      </div>

                      <div class="col-md-4">
                        <select name="office_id" id="office_id" class="form-control select_size">
                          <option value="">@lang('site.all_offices')</option>
                          @foreach ($offices as $office)
                              <option value="{{ $office->id }}" {{ request()->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                          @endforeach
                        </select>
                        <small id="studentsSearchHelp" class="form-text text-muted pb-3">@lang('site.studentsOffice_idHelp')</small>
                      </div>

                      <div class="col-md-4">
                        @php
                          $stages = [trans('site.primary_school'), trans('site.middle_school'), trans('site.secondary_school')];
                        @endphp
                        <select name="stage" id="stage" class="form-control select_size">
                            <option value="">@lang('site.stages')</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage }}" {{ request()->stage == $stage ? 'selected' : '' }}>{{ $stage }}</option>
                            @endforeach
                        </select>
                        <small id="studentsSearchHelp" class="form-text text-muted pb-3">@lang('site.studentsStageHelp')</small>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <select name="school_id" id="school_id" class="form-control select_size">

                      </select>
                      <small id="TeachersSearchHelp" class="form-text text-muted">@lang('site.SearchSchoolHelp')</small>
                    </div>
                    <div class="col-md-4">
                      @php
                          $classes = [
                              trans('site.primary_class1'), trans('site.primary_class2'), trans('site.primary_class3'),
                              trans('site.primary_class4'), trans('site.primary_class5'), trans('site.primary_class6'),
                              trans('site.middle_class1'), trans('site.middle_class2'), trans('site.middle_class3'),
                              trans('site.secondary_class1'), trans('site.secondary_class2'), trans('site.secondary_class3'),
                          ];
                      @endphp
                      <select name="class" id="class" class="form-control select_size">
                          <option value="">@lang('site.class')</option>
                          @foreach ($classes as $class)
                              <option value="{{ $class }}" {{ request()->class == $class ? 'selected' : '' }}>{{ $class }}</option>
                          @endforeach
                      </select>
                      <small id="studentsSearchHelp" class="form-text text-muted">@lang('site.studentsClassHelp')</small>
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> @lang('site.search')</button>
                      <a href="{{ route('dashboard.students.index') }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.reset')"><i class="fas fa-sync-alt"></i></a>

                      @if (auth()->user()->hasPermission('students_export'))
                          <button class="btn btn-success btn-sm float-right" id='export'><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                      @else
                          <button class="btn btn-success btn-sm float-right disabled"<i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                      @endif

                      @if (auth()->user()->hasPermission('students_create'))
                          <a href="{{ route('dashboard.students.create') }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> @lang('site.add')</a>
                      @else
                          <a href="#" class="btn btn-primary btn-sm float-right disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                      @endif
                    </div>
                  </div>
                </form><!-- end of form -->

                <div class="row">
                  <div class="col-md-12">
                      @if (auth()->user()->hasPermission('students_import'))
                          @include('partials._errors')
                          <form class="m-3 border" role="form" action="{{ route('dashboard.student_excel_import') }}" method="POST" enctype="multipart/form-data" >
                              @csrf
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" name="import_file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">اختر ملف ...</label>
                                  </div>
                                  <div class="input-group-append">
                                    <button type="submit" class="btn btn-info"><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.import')</button>
                                  </div>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="add" checked>
                                  <label class="form-check-label" for="inlineRadio1">@lang('site.add')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="update">
                                  <label class="form-check-label" for="inlineRadio2">@lang('site.update')</label>
                                </div>
                              </div>
                          </form>
                      @else
                          {{-- <a href="#" class="btn btn-warning btn-sm float-right ml-3 disabled"><i class="far fa-file-excel"></i> @lang('site.import')</a> --}}
                      @endif
                  </div>
                </div>               

                <hr>

                <div class="card-body">
                  @if ($students->count() > 0)

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr class="text-center">
                              <th><button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target=".ShowHide">#</button></th>
                              <th>@lang('site.name')</th>
                              <th>@lang('site.stage')</th>
                              <th>@lang('site.class')</th>
                              <th>@lang('site.office')</th>
                              <th>@lang('site.school')</th>
                              <th>@lang('site.programs')</th>
                              <th>@lang('site.courses')</th>
                              <th>@lang('site.related_teacher')</th>
                              <th width="10%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach ($students as $index=>$student)
                            <tr class="text-center text-bold">
                              <td>{{ $index + 1 }}</td>
                              <td>
                                <button type="button" class="btn" data-toggle="collapse" data-target="#collapseme{{$student->id}}">
                                  {{ $student->name }}
                                </button>
                              </td>
                              <td>{{ $student->stage }}</td>
                              <td>{{ $student->class }}</td>
                              <td>{{ $student->office->name }}</td>
                              <td>{{ $student->school->name }}</td>
                              <td>{{ $student->PrograsCount }}</td>
                              <td>{{ $student->CoursesCount }}</td>
                              <td><a href="{{ route('dashboard.teachers.index', ['idcard' => $student->teacher->idcard]) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-chalkboard-teacher"></i></a></td>
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

                            <tr id="collapseme{{$student->id}}" class="collapse out ShowHide text-center text-bold">
                              <td colspan="14">
                                <div class="table-responsive">
                                  <table class="table table-striped text-center" dir="rtl">
                                      <thead>
                                          <tr class="bg-secondary">
                                              <th>@lang('site.idcard')</th>
                                              <th>@lang('site.mobile')</th>
                                              <th>@lang('site.email')</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <td>{{ $student->idcard }}</td>
                                        <td>{{ $student->mobile }}</td>
                                        <td>{{ $student->email }}</td>
                                      </tbody>
                                  </table>
                                </div>
                              </td>
                            </tr>

                            @if($student->programs->count() > 0)
                              <tr id="collapseme{{$student->id}}" class="collapse out ShowHide">
                                <td colspan="14">
                                  <div class="table-responsive">
                                    <table class="table table-striped text-center" dir="rtl">
                                        <thead>
                                            <tr class="bg-info">
                                                <th>#</th>
                                                <th>@lang('site.programs')</th>
                                                <th>@lang('site.program_date')</th>
                                                <th>@lang('site.note')</th>
                                                <th>@lang('site.status')</th>
                                                <th>@lang('site.print')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->programs as $program)
                                                {{-- @if($course->pivot->active === 0) --}}
                                                    <tr class="text-center text-bold">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $program->name }}</td>
                                                        <td>{{ $program->pivot->program_date }}</td>
                                                        <td>{{ $program->pivot->program_note }}</td>
                                                        <td>
                                                          @if ($program->pivot->program_status == 1)
                                                            <i class="fas fa-check-circle text-success"></i>
                                                          @else
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                          @endif
                                                        </td>
                                                        <td>
                                                          <a href="{{ route('dashboard.students.edit', $student->id) }}" class="btn btn-info btn-sm"><i class="fa fa-print" data-toggle="tooltip" data-placement="top" title="@lang('site.print')"></i></a>
                                                        </td>
                                                    </tr>
                                                {{-- @endif --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                  </div>
                                </td>
                              </tr>
                            @endif

                            @if($student->courses->count() > 0)
                              <tr id="collapseme{{$student->id}}" class="collapse out ShowHide">
                                <td colspan="14">
                                  <div class="table-responsive">
                                    <table class="table table-striped text-center" dir="rtl">
                                        <thead>
                                            <tr class="bg-info">
                                                <th>#</th>
                                                <th>@lang('site.courses')</th>
                                                <th>@lang('site.course_date')</th>
                                                <th>@lang('site.note')</th>
                                                <th>@lang('site.status')</th>
                                                <th>@lang('site.print')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student->courses as $course)
                                              <tr class="text-center text-bold">
                                                  <td>{{ $loop->iteration }}</td>
                                                  <td>{{ $course->name }}</td>
                                                  <td>{{ $course->pivot->course_date }}</td>
                                                  <td>{{ $course->pivot->course_note }}</td>
                                                  <td>
                                                    @if ($course->pivot->course_status == 1)
                                                      <i class="fas fa-check-circle text-success"></i>
                                                    @else
                                                      <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                  </td>
                                                  <td>
                                                    <a href="{{ route('dashboard.students.edit', $student->id) }}" class="btn btn-info btn-sm"><i class="fa fa-print" data-toggle="tooltip" data-placement="top" title="@lang('site.print')"></i></a>
                                                  </td>                                                  
                                              </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                  </div>
                                </td>
                              </tr>
                            @endif  

                          @endforeach
                        </tbody>
                      </table>
                      <!-- end of table -->

                    </div>

                    {{ $students->appends(request()->query())->links() }}
                  
                  @else
                      
                      <h2>@lang('site.no_data_found')</h2>
                      
                  @endif
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
        dependentSchools();
        $(document).on('change', '#office_id', function() {
            dependentSchools();
            return false;
        });
        function dependentSchools() {
            $('option', $('#school_id')).remove();
            var translate = @json( __('site.all_schools') );
            $('#school_id').append($('<option></option>').val('').html(translate));
            var officeIdVal = $('#office_id').val() != null ? $('#office_id').val() : '{{ old('office_id') }}';
            var stageVal = $('#stage').val() != null ? $('#stage').val() : '{{ old('stage') }}';
            $.get("{{ route('dashboard.get_schools') }}", { office_id: officeIdVal , stage: stageVal }, function (data) {
                $.each(data, function(val, text) {
                    var selectedVal = text == '{{ request()->school_id }}' ? "selected" : "";
                    $('#school_id').append($('<option ' + selectedVal + '></option>').val(text).html(val));
                    //console.log(val,text);
                })
            }, "json");
        }

        dependentStages()
        $(document).on('change', '#stage', function() {
            dependentStages();
            dependentSchools();
            return false;
        });

        function dependentStages() {
          $('option', $('#class')).remove();
          var all_stage = @json( __('site.class') );
          var transStage = all_stage == '{{ request()->class }}' ? "selected" : "";
          $('#class').append($('<option ' + selectedVal + '></option>').val('').html(all_stage));

          //console.log(transStage1 , transStage2 ,transStage3);
          var current_Stage = $('#stage').val();
          switch (current_Stage) {
            case 'ابتدائي':
              var transStage1 = [ @json( __('site.primary_class1') ) , @json( __('site.primary_class2') ), @json( __('site.primary_class3') ),
                                  @json( __('site.primary_class4') ) , @json( __('site.primary_class5') ), @json( __('site.primary_class6') )];
              
              var classLen = transStage1.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage1[i] == '{{ request()->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage1[i]).html(transStage1[i]));
              }
              break;
            case 'متوسط':
              var transStage2 = [ @json( __('site.middle_class1') ) , @json( __('site.middle_class2') ), @json( __('site.middle_class3') )];

              var classLen = transStage2.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage2[i] == '{{ request()->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage2[i]).html(transStage2[i]));
              }
              break;
            case 'ثانوي':
              var transStage3 = [ @json( __('site.secondary_class1') ) , @json( __('site.secondary_class2') ), @json( __('site.secondary_class3') )];

              var classLen = transStage3.length;

              for (i = 0; i < classLen; i++) {
                var selectedVal = transStage3[i] == '{{ request()->class }}' ? "selected" : "";
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
                var selectedVal = transStage[i] == '{{ request()->class }}' ? "selected" : "";
                $('#class').append($('<option ' + selectedVal + '></option>').val(transStage[i]).html(transStage[i]));
              }
          }
        }

        // export Excel File
        $(document).on('click', '#export', function(event) {
          event.preventDefault();
          var searchVal = $('#search').val() != null ? $('#search').val() : '{{ old('search') }}';
          var office_idVal = $('#office_id').val() != null ? $('#office_id').val() : '{{ old('office_id') }}';
          var school_idVal = $('#school_id').val() != null ? $('#school_id').val() : '{{ old('school_id') }}';
          console.log(school_idVal);
          var stageVal = $('#stage').val() != null ? $('#stage').val() : '{{ old('stage') }}';
          var classVal = $('#class').val() != null ? $('#class').val() : '{{ old('class') }}';

          gotoUrl("{{ route('dashboard.student_excel_export') }}", {_token : "{{ csrf_token() }}", search : searchVal , office_id : office_idVal , school_id : school_idVal , stage : stageVal , class : classVal });
          // return false;
        });
    });    
  </script>
    
@endsection