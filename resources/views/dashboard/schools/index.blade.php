@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.schools') <small>( {{ $schools->total() }} )</small></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.schools')</li>
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

                <form class="m-3" action="{{ route('dashboard.schools.index') }}" method="get">

                  <div class="row">

                      <div class="col-md-3">
                          <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                          <small id="SchoolsSearchHelp" class="form-text text-muted">@lang('site.SchoolsSearchHelp')</small>
                      </div>

                      <div class="col-md-3">
                        <select name="office_id" class="form-control">
                            <option value="">@lang('site.all_offices')</option>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" {{ request()->office_id == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                            @endforeach
                        </select>
                        <small id="SchoolsSearchHelp" class="form-text text-muted">@lang('site.SchoolsOffice_idHelp')</small>
                      </div>

                      <div class="col-md-3">
                        @php
                          $stages = [trans('site.primary_school'), trans('site.middle_school'), trans('site.secondary_school')];
                        @endphp
                        <select name="stage" class="form-control">
                            <option value="">@lang('site.stages')</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage }}" {{ request()->stage == $stage ? 'selected' : '' }}>{{ $stage }}</option>
                            @endforeach
                        </select>
                        <small id="SchoolsSearchHelp" class="form-text text-muted">@lang('site.SchoolsStageHelp')</small>
                      </div>

                      <div class="col-md-3">
                          <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> @lang('site.search')</button>
                          @if (auth()->user()->hasPermission('schools_create'))
                              <a href="{{ route('dashboard.schools.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @else
                              <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @endif
                      </div>

                  </div>
                </form><!-- end of form -->

                <hr>

                <div class="card-body">
                  @if ($schools->count() > 0)

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr>
                              <th>#</th>
                              <th>@lang('site.name')</th>
                              <th width="120px" class="text-center">@lang('site.moeid')</th>
                              <th class="text-center">@lang('site.office')</th>
                              <th class="text-center">@lang('site.stage')</th>
                              <th>@lang('site.manager')</th>
                              <th class="text-center">@lang('site.mobile')</th>
                              <th class="text-center">@lang('site.email')</th>
                              <th width="18%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @foreach ($schools as $index=>$school)
                              <tr>
                                  <td class="text-center">{{ $index + 1 }}</td>
                                  <td>{{ $school->name }}</td>
                                  <td class="text-center">{{ $school->moe_id }}</td>
                                  <td class="text-center">{{ $school->office->name }}</td>
                                  <td class="text-center">{{ $school->stage }}</td>
                                  <td>{{ $school->manager }}</td>
                                  <td class="text-center">{{ $school->mobile }}</td>
                                  <td class="text-center">{{ $school->email }}</td>
                                  <td class="text-center">
                                      @if (auth()->user()->hasPermission('schools_update'))
                                          <a href="{{ route('dashboard.schools.edit', $school->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if (auth()->user()->hasPermission('schools_delete'))
                                          <form action="{{ route('dashboard.schools.destroy', $school->id) }}" method="post" style="display: inline-block">
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

                    
                  
                    {{ $schools->appends(request()->query())->links() }}
                  
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