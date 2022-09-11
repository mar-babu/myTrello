@extends('backend.layouts.master')

@section('title', 'Project Create - Admin Panel')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
@endsection


@section('content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Create Project</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('project.list') }}">All Projects</a></li>
                        <li><span>Create Project</span></li>
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
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Create New Project</h4>

                        @include('backend.layouts.partials.messages')

                        <form method="post" action="{{ route('project.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="workspace_id" class="col-form-label"> Workspace </label>
                                    <select name="workspace_id" id="workspaceId" class="form-control select2 @error('workspace_id') is-invalid @enderror">
                                        <option>Choose Workspace</option>
                                        @foreach($workspaces as $value)
                                        <option value="{{ $value->id }}" {{ old('workspace_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('workspace_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="name"> Project Name </label>
                                    <input type="text" class="form-control @error('name', 'project') is-invalid @enderror" id="name" name="name"
                                           placeholder="Enter Project Name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="description"> Project Description </label>
                                    <input type="text-area" class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                           placeholder="Enter Project Description" value="{{ old('description') }}">
                                    @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="price"> Project Cost </label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost"
                                           placeholder="Enter Project Cost" value="{{ old('cost') }}">
                                    @error('cost')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="status"> Finish Date </label>
                                    <input type="date" class="form-control @error('to_date') is-invalid @enderror" id="toDate" name="to_date"
                                           placeholder="Enter Project Cost" value="{{ old('to_date') }}">
                                    @error('to_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="status"> Address </label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                           placeholder="Enter Project Address" value="{{ old('address') }}">
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Create Project</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        })
    </script>

@endsection
