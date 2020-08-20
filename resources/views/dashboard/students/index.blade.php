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
                          <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
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

                      @if (auth()->user()->hasPermission('students_create'))
                          <a href="{{ route('dashboard.student_excel_export') }}" class="btn btn-success btn-sm float-right"><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</a>
                      @else
                          <a href="#" class="btn btn-success btn-sm float-right disabled"><i class="far fa-file-excel"></i> @lang('site.export')</a>
                      @endif

                      @if (auth()->user()->hasPermission('students_create'))
                          <a href="{{ route('dashboard.students.create') }}" class="btn btn-primary btn-sm float-right ml-3"><i class="fa fa-plus"></i> @lang('site.add')</a>
                      @else
                          <a href="#" class="btn btn-primary btn-sm float-right ml-3 disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                      @endif
                    </div>
                  </div>
                </form><!-- end of form -->

                <div class="row">
                  <div class="col-md-12">
                      @if (auth()->user()->hasPermission('students_create'))
                          @include('partials._errors')
                          <form class="m-3" role="form" action="{{ route('dashboard.student_excel_import') }}" method="POST" enctype="multipart/form-data" >
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
                          <a href="#" class="btn btn-warning disabled"><i class="far fa-file-excel"></i> @lang('site.import')</a>
                      @endif
                  </div>
                </div>               

                <hr>

                <div class="card-body">
                  @if ($students->count() > 0)

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr>
                              <th>#</th>
                              <th>@lang('site.name')</th>
                              <th width="120px" class="text-center">@lang('site.idcard')</th>
                              <th class="text-center">@lang('site.stage')</th>
                              <th class="text-center">@lang('site.class')</th>
                              <th class="text-center">@lang('site.school')</th>
                              <th class="text-center">@lang('site.office')</th>
                              <th class="text-center">@lang('site.mobile')</th>
                              <th class="text-center">@lang('site.email')</th>
                              <th class="text-center">@lang('site.related_teacher')</th>
                              <th width="18%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach ($students as $index=>$student)
                              <tr>
                                  <td class="text-center">{{ $index + 1 }}</td>
                                  <td>{{ $student->name }}</td>
                                  <td class="text-center">{{ $student->idcard }}</td>
                                  <td class="text-center">{{ $student->stage }}</td>
                                  <td class="text-center">{{ $student->class }}</td>
                                  <td class="text-center">{{ $student->school->name }}</td>
                                  <td class="text-center">{{ $student->office->name }}</td>
                                  <td class="text-center">{{ $student->mobile }}</td>
                                  <td class="text-center english_text">{{ $student->email }}</td>
                                  <td class="text-center"><a href="{{ route('dashboard.teachers.index', ['teacher_id' => $student->teacher->id]) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-chalkboard-teacher"></i></a></td>
                                  <td class="text-center">
                                      @if (auth()->user()->hasPermission('students_update'))
                                          <a href="{{ route('dashboard.students.edit', $student->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if (auth()->user()->hasPermission('students_delete'))
                                          <form action="{{ route('dashboard.students.destroy', $student->id) }}" method="post" style="display: inline-block">
                                              {{ csrf_field() }}
                                              {{ method_field('delete') }}
                                              <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                          </form><!-- end of form -->
                                      @else
                                          <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                      @endif
                                  </td>
                              </tr>
                          
                          @endforeach
                        </tbody>

                      </table><!-- end of table -->

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
            $.get("{{ route('dashboard.get_schools') }}", { office_id: officeIdVal }, function (data) {
                $.each(data, function(val, text) {
                    var selectedVal = val == '{{ request()->school_id }}' ? "selected" : "";
                    $('#school_id').append($('<option ' + selectedVal + '></option>').val(val).html(text));
                    //console.log(val,text);
                })
            }, "json");
        }

        dependentStages()
        $(document).on('change', '#stage', function() {
            dependentStages();
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
    });    
  </script>
    
@endsection