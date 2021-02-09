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
                  {{-- <li class="breadcrumb-item active"><a href="{{ route('dashboard.students.edit')}}">@lang('site.edit')</a></li> --}}
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

                <div class="row">
                  <div class="col-sm-6">
                    <div class="card card-info">
                      <div class="card-header">
                        @lang('site.programs')
                      </div>
                      <div class="card-body">
                        <form action="{{ route('dashboard.students.programs.edit', [$student->id, $program] ) }}" method="post">
                          @csrf
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>@lang('site.programs')</label>
                                <select name="program_id" id="program_id" class="form-control select_size">
                                  @foreach ($programs as $program)
                                      <option value="{{ $program->id }} {{ $student->programs->contains($program->id) ? 'selected' : '' }}" >{{ $program->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>@lang('site.program_date')</label>
                                <input type='text' name="program_date" class="form-control hijri-date-input"  value="{{ $student->program_date }}">   
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label>@lang('site.note')</label>
                            <textarea name="program_note" cols="20" rows="4" class="form-control">{{ $student->program_note }}</textarea>
                          </div>

                          <div class="form-group">
                            <label><input name="program_status" type="checkbox" value="1" {{  ($student->program_status == 1 ? ' checked' : '') }}> @lang('site.status')</label>
                          </div>                 

                      </div>
                      <div class="card-footer">
                        <div class="form-group">
                          <button type="submit" class="btn btn-info"><i class="fas fa-edit"></i> @lang('site.edit')</button>
                        </div>   
                      </div> 
                    </form>                     
                    </div>
                                    
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