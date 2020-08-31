@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.offices') <small>( {{ $offices->total() }} )</small></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.offices')</li>
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

                <form class="m-3" action="{{ route('dashboard.offices.index') }}" method="get">

                  <div class="row">

                      <div class="col-md-6">
                          <input type="text" name="search" id="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                      </div>

                      <div class="col-md-6">
                          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> @lang('site.search')</button>

                          <a href="{{ route('dashboard.offices.index') }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.reset')"><i class="fas fa-sync-alt"></i></a>

                          @if (auth()->user()->hasPermission('offices_export'))
                              <button class="btn btn-success btn-sm float-right" id='export'><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                          @else
                              <button class="btn btn-success btn-sm float-right disabled"<i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                          @endif

                          @if (auth()->user()->hasPermission('offices_create'))
                              <a href="{{ route('dashboard.offices.create') }}" class="btn btn-primary btn-sm float-right ml-3"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @else
                              <a href="#" class="btn btn-primary btn-sm float-right ml-3 disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @endif
                      </div>

                  </div>
                </form><!-- end of form -->

                <div class="row">
                  <div class="col-md-12">
                      @if (auth()->user()->hasPermission('offices_import'))
                          @include('partials._errors')
                          <form class="m-3" role="form" action="{{ route('dashboard.office_excel_import') }}" method="POST" enctype="multipart/form-data" >
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
                          <a href="#" class="btn btn-warning btn-sm float-right ml-3 disabled"><i class="far fa-file-excel"></i> @lang('site.import')</a>
                      @endif
                  </div>
                </div>
                
                <hr>

                <div class="card-body">
                  {{-- @if ($offices->count() > 0) --}}

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr>
                              <th>#</th>
                              <th>@lang('site.name')</th>
                              <th class="text-center">@lang('site.schools_count')</th>
                              <th class="text-center">@lang('site.related_schools')</th>
                              <th width="20%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @forelse ($offices as $index=>$office)
                              <tr>
                                  <td>{{ $index + 1 }}</td>
                                  <td>{{ $office->name }}</td>
                                  <td class="text-center">{{ $office->schools->count() }}</td>
                                  <td class="text-center"><a href="{{ route('dashboard.schools.index', ['office_id' => $office->id]) }}" class="btn btn-success btn-sm"><i class="fas fa-school"></i></a></td>
                                  <td class="text-center">
                                      @if (auth()->user()->hasPermission('offices_update'))
                                          <a href="{{ route('dashboard.offices.edit', $office->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if (auth()->user()->hasPermission('offices_delete'))
                                          <form action="{{ route('dashboard.offices.destroy', $office->id) }}" method="post" style="display: inline-block">
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

                    
                  
                    {{ $offices->appends(request()->query())->links() }}
                  
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

@section('scripts')
  <script>
    $(function () {
        $(document).on('click', '#export', function() {
          var searchVal = $('#search').val() != null ? $('#search').val() : '{{ old('search') }}';
          gotoUrl("{{ route('dashboard.office_excel_export') }}", {_token : "{{ csrf_token() }}", search :searchVal});
          return false;
        });
    });    
  </script>
    
@endsection