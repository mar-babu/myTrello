@extends('backend.layouts.master')

@section('title', 'Projects - Admin Panel')

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">

@endsection


@section('content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Admins</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><span>All Projects</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <!-- filter start -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/project/filter') }}" method="get">
                        <div class="row">
                            <div class="col-2">
                                <select class="form-control filter_column" name="filter_column">
                                    <option selected="selected" value="">Select Column</option>
                                    <option value="from_date">From Date</option>
                                    <option value="to_date">To Date</option>
                                    <option value="created_by">User</option>
                                    <option value="workspace">Workspace</option>
                                    <option value="name">Project Name</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <input class="form-control" placeholder="Filter String" name="filter_string" type="text">
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-md btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- filter end -->

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Products List</h4>
                    <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{ route('project.create') }}">Create New Project</a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center project-table">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Workspace</th>
                                    <th width="10%">Name</th>
                                    <th width="20%">Description</th>
                                    <th width="5%">Cost</th>
                                    <th width="8%">From Date</th>
                                    <th width="8%">To Date</th>
                                    <th width="14%">Address</th>
                                    <th width="5%">Status</th>
                                    <th width="10%">Created By</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="projectList">
                               @foreach ($projects as $project)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $project->workspace->name }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->cost }}</td>
                                    <td>{{ $project->from_date }}</td>
                                    <td>{{ $project->to_date }}</td>
                                    <td>{{ $project->address }}</td>
                                    <td>
                                        <span class="badge {{ $project->status == 1 ? 'badge-success' : 'badge-secondary' }} mr-1">
                                            {{ $project->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                   <td>{{ $project->createdBy->name }}</td>
                                   <td>
                                       <a href="{{ url('/project/' . $project->id . '/space') }}" class="btn btn-primary">
                                           <span class="fa fa-rocket"></span>
                                       </a>
                                   </td>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>

@endsection


@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

     <script>
     /*================================
     datatable active
     ==================================*/
     if ($('#dataTable').length) {
     $('#dataTable').DataTable({
     responsive: true
     });
     }

     </script>

@endsection
