<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('workspace', 'createdBy')->get();

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

            //project member create
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

}
