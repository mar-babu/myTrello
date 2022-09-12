@extends('backend.layouts.master')

@section('title', 'Projects - Admin Panel')

@section('content')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Admins</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><span>Project Space</span></li>
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
        <!-- project space start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Project Space</h4>
                    <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{ route('project.create') }}">Create New Project</a>
                    </p>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-4 mt-md-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg1">
                            <a href="">
                                <div class="p-4 justify-content-between align-items-center">
                                    <div class="seofct-icon d-flex flex-row"><i class="fa fa-industry"></i><h1>Workspace</h1></div>
                                    <div class="list-group d-flex justify-content-between">
                                        <h2>{{ $project->workspace->name }}</h2>
                                        <p>{{ $project->workspace->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg2">
                            <a href="">
                                <div class="p-4 justify-content-between align-items-center">
                                    <div class="seofct-icon d-flex flex-row"><i class="fa fa-building"></i><h1>Project</h1></div>
                                    <div class="list-group d-flex justify-content-between">
                                        <h2>{{ $project->name }}</h2>
                                        <p>{{ $project->description }}</p>
                                        <p>BDT {{ $project->cost }}</p>
                                        <p>{{ $project->from_date }} -> {{ $project->to_date }}</p>
                                        <p>{{ $project->address }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-md-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg3">
                            <a href="">
                                <div class="p-4 justify-content-between align-items-center">
                                    <div class="seofct-icon d-flex flex-row"><i class="fa fa-user"></i><h1>Created By</h1></div>
                                    <div class="list-group d-flex justify-content-between">
                                        <h2>{{ $project->createdBy->name }}</h2>
                                        <p>{{ $project->createdBy->email }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-md-5 mb-3">
                    <div class="card">
                        <div class="seo-fact sbg4">
                            <a href="">
                                <div class="p-4 justify-content-between align-items-center">
                                    <div class="seofct-icon d-flex flex-row"><i class="fa fa-users"></i><h1>Members</h1></div>
                                    <div class="list-group d-flex justify-content-between">
                                        @foreach($project->projectMember as $member)
                                        <p>{{ $member->user->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-md-5 mb-3 mb-lg-0">
                    <a data-toggle="modal" data-target="#addMemberModalCenter" title="Add Member">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon d-flex flex-row">
                                        <i class="fa fa-user-plus"></i>
                                        <h1> Add Member </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- project space end -->
        
    </div>
</div>

<div class="modal fade" id="addMemberModalCenter" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Member to Project</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <form method="post" action="{{ url('/project/' . $project->id . '/member') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-row">
                                <div class="form-group col-md-12 col-sm-12">
                                    <label for="userId" class="col-form-label"> Find Member </label>
                                    <select name="user_id" id="userId" class="form-control select2 @error('user_id') is-invalid @enderror">
                                        <option>Choose Member</option>
                                        @if(isset($notMemberLists))
                                            @foreach($notMemberLists as $value)
                                                <option value="{{ $value->id }}" {{ old('user_id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
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
