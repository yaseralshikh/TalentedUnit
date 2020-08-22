@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.supervisors') <small>( {{ $supervisors->total() }} )</small></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.supervisors')</li>
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

                <form class="m-3" action="{{ route('dashboard.supervisors.index') }}" method="get">

                  <div class="row">

                      <div class="col-md-3">
                          <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                          <small id="TeachersSearchHelp" class="form-text text-muted">@lang('site.SupervisorsSearchHelp')</small>
                      </div>

                      <div class="col-md-3">
                          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> @lang('site.search')</button>
                          <a href="{{ route('dashboard.supervisors.index') }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.reset')"><i class="fas fa-sync-alt"></i></a>

                          @if (auth()->user()->hasPermission('supervisors_create'))
                              <a href="{{ route('dashboard.supervisors.create') }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @else
                              <a href="#" class="btn btn-primary disabled btn-sm float-right"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @endif
                      </div>

                  </div>
                </form><!-- end of form -->               

                <hr>

                <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr>
                              <th>#</th>
                              <th>@lang('site.name')</th>
                              <th>@lang('site.office_id')</th>
                              <th>@lang('site.related_schools')</th>
                              <th width="20%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @forelse ($supervisors as $index=>$supervisor)
                              <tr>
                                  <td>{{ $index + 1 }}</td>
                                  <td>{{ $supervisor->name }}</td>
                                  {{-- <td class="text-center">{{ $supervisor->office->name }}</td> --}}
                                  <td class="text-center">xxx</td>
                                  <td><a href="#" class="btn btn-success btn-sm"><i class="fas fa-school"></i> @lang('site.related_schools')</a></td>
                                  {{-- <td><a href="{{ route('dashboard.schools.index', ['office_id' => $office->id]) }}" class="btn btn-success btn-sm"><i class="fas fa-school"></i> @lang('site.related_schools')</a></td> --}}
                                  <td class="text-center">
                                      @if (auth()->user()->hasPermission('supervisors_update'))
                                          <a href="{{ route('dashboard.supervisors.edit', $supervisor->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if (auth()->user()->hasPermission('supervisors_delete'))
                                          <form action="{{ route('dashboard.supervisors.destroy', $supervisor->id) }}" method="post" style="display: inline-block">
                                              {{ csrf_field() }}
                                              {{ method_field('delete') }}
                                              <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                          </form><!-- end of form -->
                                      @else
                                          <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                      @endif
                                  </td>
                              </tr>

                          @empty
                              <tr>
                                <td colspan="5" class="text-center">
                                  <h2>@lang('site.no_data_found')</h2>
                                </td>
                              </tr>
                          @endforelse
                        </tbody>

                      </table><!-- end of table -->

                    </div>

                    
                  
                    {{ $supervisors->appends(request()->query())->links() }}
                  
                  {{-- @else
                      
                      <h2>@lang('site.no_data_found')</h2>
                      
                  @endif --}}
                </div>
                  <!-- /.card-body -->

              </div>
              <!-- /.card -->

          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>

@endsection