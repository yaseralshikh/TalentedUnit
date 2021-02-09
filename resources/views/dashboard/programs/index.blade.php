@extends('layouts.dashboard.app')

@section('content')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.programs') <small>( {{ $programs->total() }} )</small></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">@lang('site.programs')</li>
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

                <form class="m-3" action="{{ route('dashboard.programs.index') }}" method="get">

                  <div class="row">

                      <div class="col-md-6">
                          <input type="text" name="search" id="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                      </div>

                      <div class="col-md-6">
                          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> @lang('site.search')</button>

                          <a href="{{ route('dashboard.programs.index') }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.reset')"><i class="fas fa-sync-alt"></i></a>

                          @if (auth()->user()->hasPermission('programs_export'))
                              <button class="btn btn-success btn-sm float-right" id='export'><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                          @else
                              <button class="btn btn-success btn-sm float-right disabled"><i class="far fa-file-excel" aria-hidden="true"></i> @lang('site.export')</button>
                          @endif

                          @if (auth()->user()->hasPermission('programs_create'))
                              <a href="{{ route('dashboard.programs.create') }}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @else
                              <a href="#" class="btn btn-primary btn-sm float-right disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                          @endif
                      </div>

                  </div>
                </form><!-- end of form -->
                
                <hr>

                <div class="card-body">
                  {{-- @if ($programs->count() > 0) --}}

                    <div class="table-responsive">
                      <table class="table table-hover">

                        <thead class="bg-dark">
                          <tr>
                              <th>#</th>
                              <th>@lang('site.name')</th>
                              <th>@lang('site.description')</th>
                              <th>@lang('site.created_at')</th>
                              {{-- <th class="text-center">@lang('site.related_schools')</th> --}}
                              <th width="10%" colspan="2" class="text-center">@lang('site.action')</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          @forelse ($programs as $index=>$program)
                              <tr>
                                  <td>{{ $index + 1 }}</td>
                                  <td class="h6 text-justify">{{ $program->name }}</td>
                                  <td class="h6 text-justify">{{ $program->description }}</td>
                                  <td class="h6 text-justify">{{ Alkoumi\LaravelHijriDate\Hijri::Date('Y', $program->created_at) }} هـ</td>
                                  {{-- <td class="text-center"><a href="{{ route('dashboard.schools.index', ['program_id' => $program->id]) }}" class="btn btn-success btn-sm"><span class="border border-warning bg-dark">&nbsp;{{ $program->schools->count() }}&nbsp;</span> <i class="fas fa-school"></i></a></td> --}}
                                  <td class="text-center">
                                      @if (auth()->user()->hasPermission('programs_update'))
                                          <a href="{{ route('dashboard.programs.edit', $program->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="@lang('site.edit')"><i class="fa fa-edit"></i></a>
                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i></a>
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if (auth()->user()->hasPermission('programs_delete'))
                                          <form action="{{ route('dashboard.programs.destroy', $program->id) }}" method="post" style="display: inline-block">
                                              {{ csrf_field() }}
                                              {{ method_field('delete') }}
                                              <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="@lang('site.delete')"></i></button>
                                          </form><!-- end of form -->
                                      @else
                                          <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i></button>
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

                    
                  
                    {{ $programs->appends(request()->query())->links() }}
                  
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
        $(document).on('click', '#export', function(event) {
          event.preventDefault();
          var searchVal = $('#search').val() != null ? $('#search').val() : '{{ old('search') }}';
          gotoUrl("{{ route('dashboard.program_excel_export') }}", {_token : "{{ csrf_token() }}", search :searchVal});
          return false;
        });
    });    
  </script>
    
@endsection