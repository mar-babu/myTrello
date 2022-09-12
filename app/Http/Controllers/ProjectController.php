<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('workspace', 'createdBy', 'projectMember')
            ->whereHas('projectMember', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->get();

        return view('backend.pages.project.index', compact('projects'));
    }

    public function create()
    {
        $workspaces = Workspace::get();

        return view('backend.pages.project.create', compact('workspaces'));
    }

    public function store(ProjectRequest $projectRequest)
    {
        try {
            DB::beginTransaction();
            //project create
            $project = new Project();
            $project->workspace_id = $projectRequest->workspace_id;
            $project->name = $projectRequest->name;
            $project->description = $projectRequest->description;
            $project->cost = $projectRequest->cost;
            $project->from_date = Carbon::now();
            $project->to_date = $projectRequest->to_date;
            $project->address = $projectRequest->address;
            $project->created_by = auth()->user()->id;
            $project->save();

            //make project member when one create project
            $projectMember = $this->userProject($project);
            $project->projectMember()->save($projectMember);
            DB::commit();

            return redirect('/project/index');
        } catch (Exception $exception) {
            DB::rollBack();
            return false;

        }
    }

    public function userProject($project)
    {
        $projectMember = new ProjectMember();
        $projectMember->project_id = $project->id;
        $projectMember->user_id = auth()->user()->id;

        return $projectMember;
    }

    //make other member as project member
    public function makeProjectMember(Request $request, $projectId)
    {
        try {
            DB::beginTransaction();
            $projectMember = new ProjectMember();
            $projectMember->project_id = $projectId;
            $projectMember->user_id = $request->user_id;
            $projectMember->invited_by_user_id = auth()->user()->id;
            $projectMember->save();

            DB::commit();
            return redirect('/project/' . $projectId . '/space');
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }

    public function projectSpace($projectId)
    {
        $project = Project::with('workspace', 'createdBy', 'projectMember', 'projectMember.user')
            ->whereHas('projectMember', function ($query) use ($projectId) {
                $query->where('project_id', $projectId);
            })->first();

        $memberLists = ProjectMember::with('user')
            ->whereHas('user', function ($query) use ($projectId) {
                $query->where('project_id', $projectId);
            })
            ->pluck('user_id');

        $notMemberLists = User::whereNotIn('id', $memberLists)->get();

        return view('backend.pages.project.space', compact( 'project', 'notMemberLists'));
    }

    //product filter by price range, sort by, status
    public function filter(Request $request)
    {
        $query = Project::query();
        $filter_column = $request->filter_column;
        $filter_string = $request->filter_string;

        if ($filter_column == 'from_date') {
            $query->where('from_date', $filter_string);
        }

        if ($filter_column == 'to_date') {
            $query->where('to_date', $filter_string);
        }

        if ($filter_column == 'created_by') {
            $query->whereHas('createdBy', function ($q) use ($filter_string) {
                $q->where('name', 'like', '%' . $filter_string . '%');
            });
        }

        if ($filter_column == 'workspace') {
            $query->whereHas('workspace', function ($q) use ($filter_string) {
                $q->where('name', 'like', '%' . $filter_string . '%');
            });
        }

        if ($filter_column == 'name') {
            $query->where('name', 'like', '%' . $filter_string . '%');
        }

        $projects = $query->get();

        return view('backend.pages.project.index', compact('projects'));
    }
    
}
