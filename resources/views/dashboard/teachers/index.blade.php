@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.teachers') <small>( {{ $teachers->total() }} )</small></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.teachers')</li>
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

                <form class="m-3" action="{{ route('dashboard.teachers.index') }}" method="get">

                  <div class="row">

                      <div class="col-md-3">
                          <input type="text" name="search" id="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                          <small id="TeachersSearchHelp" class="form-text text-muted">@lang('site.TeachersSearchHelp')</small>
                      </div>

                      <div class="col-md-3">
                        <select name="office_id" id="office_id" class="form-control select_size">
                            <option value="">@lang('site.all_offices')</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ request()->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                            @endforeach
                        </select>
                        <small id="TeachersSearchHelp" class="form-text text-muted">@lang('site.SearchOfficeHelp')</small>
                      </div>

                      <div class="col-md-3">
                        <select name="school_id" id="school_id" class="form-control select_size">

                        </select>
                        <small id="TeachersSearchHelp" class="form-text text-muted">@lang('site.SearchSchoolHelp')</small>
                      </div>

                      <div class="col-md-3">
                          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> @lang('site.search')</button>
                          <a href="{{ route('dashboard.teachers.index') }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.reset')"><i class="fas fa-sync-alt"></i></a>

                          @if (auth()->user()->hasPermission('teachers_export'))
                              <button class="btn btn-success btn-sm float-right" id='export'><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                          @else
                              <button class="btn btn-success btn-sm float-right disabled"<i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                          @endif

                          @if (auth()->user()->hasPermission('teachers_create'))
                              <a href="{{ route('dashboard.teachers.create') }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @else
                              <a href="#" class="btn btn-primary disabled btn-sm float-right"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @endif
                      </div>

                  </div>
                </form><!-- end of form -->

                <div class="row">
                  <div class="col-md-12">
                      @if (auth()->user()->hasPermission('teachers_import'))
                          @include('partials._errors')
                          <form class="m-3 border" role="form" action="{{ route('dashboard.teacher_excel_import') }}" method="POST" enctype="multipart/form-data" >
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
                  @if ($teachers->count() > 0)

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr>
                              <th>#</th>
                              <th>@lang('site.name')</th>
                              <th class="text-center">@lang('site.image')</th>
                              <th width="120px" class="text-center">@lang('site.idcard')</th>
                              <th class="text-center">@lang('site.mobile')</th>
                              <th class="text-center">@lang('site.email')</th>
                              <th class="text-center">@lang('site.office')</th>
                              <th class="text-center">@lang('site.school')</th>
                              <th class="text-center">@lang('site.specialization')</th>
                              <th class="text-center">@lang('site.students')</th>
                              <th width="10%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach ($teachers as $index=>$teacher)
                              <tr>
                                  <td class="text-center">{{ $index + 1 }}</td>
                                  <td>{{ $teacher->name }}</td>
                                  <td class="text-center">
                                    <img src="{{ $teacher->image_path }}" style="width: 50px;" class="img-thumbnail" alt="">
                                  </td>
                                  <td class="text-center">{{ $teacher->idcard }}</td>
                                  <td class="text-center">{{ $teacher->mobile }}</td>
                                  <td class="text-center english_text">{{ $teacher->email }}</td>
                                  <td class="text-center">{{ $teacher->office->name }}</td>
                                  <td class="text-center">{{ $teacher->school->name }}</td>
                                  <td class="text-center">{{ $teacher->specialization }}</td>
                                  <td class="text-center"><a href="{{ route('dashboard.students.index', ['teacher_id' => $teacher->idcard , 'school_id' => $teacher->school->moe_id ]) }}" class="btn btn-secondary btn-sm">{{ $teacher->students->where('school_id', $teacher->school->moe_id)->count() }} <i class="nav-icon fas fa-user-graduate"></i></a></td>
                                  <td class="text-center">
                                      @if (auth()->user()->hasPermission('teachers_update'))
                                          <a href="{{ route('dashboard.teachers.edit', $teacher->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if (auth()->user()->hasPermission('teachers_delete'))
                                          <form action="{{ route('dashboard.teachers.destroy', $teacher->id) }}" method="post" style="display: inline-block">
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

                      </table><!-- end of table -->

                    </div>

                    
                  
                    {{ $teachers->appends(request()->query())->links() }}
                  
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

        // Fill Schools select options
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
                    var selectedVal = text == '{{ request()->school_id }}' ? "selected" : "";
                    $('#school_id').append($('<option ' + selectedVal + '></option>').val(text).html(val));
                })
            }, "json");
        }

        // export Excel File
        $(document).on('click', '#export', function(event) {
          event.preventDefault();
          var searchVal = $('#search').val() != null ? $('#search').val() : '{{ old('search') }}';
          var office_idVal = $('#office_id').val() != null ? $('#office_id').val() : '{{ old('office_id') }}';
          var school_idVal = $('#school_id').val() != null ? $('#school_id').val() : '{{ old('school_id') }}';

          gotoUrl("{{ route('dashboard.teacher_excel_export') }}", {_token : "{{ csrf_token() }}", search : searchVal , office_id : office_idVal , school_id : school_idVal });
          return false;
        });
    });    
  </script>
    
@endsection