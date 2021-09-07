<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\UserProject;
use App\Models\ProjectRemark;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectEmail;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index(){
        return '';
    }

    public function add(Request $request){
        try{
            $project_id = Project::create([
                'job' => $request->job,
                'title' => $request->title,
                'location' => $request->location,
                'department_id' => (int)$request->department_id,
                'client' => $request->client,
                'assigned_manager' => $request->assigned_manager,
                'active' => $request->active,
                'user_id' => Auth::user()->pf
            ])->job;

            if(isset($request->remarks)){
                foreach ($request->remarks as $remark) {
                    ProjectRemark::create([
                        'code' => $remark['code'],
                        'remarks' => $remark['remark'],
                        'project_id' => $project_id
                    ]);
                }
            }
            
            $user = User::where('pf', $request->assigned_manager)->first();
            $data = array(
                'name' => $user['first_name'] . ' ' . $user['last_name']
            );
            Mail::to($user['email'])->send(new ProjectEmail($data));
            
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }

        return response()->json('success');
    }

    public function projectList(){
        try{
            return UserProject::where('user_id', Auth::user()->pf)->with('getProject')->get();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function get(Request $request){
        $duration = $request->duration;
        try{
            if($duration==0){
                return Project::whereDate('created_at', Carbon::today())->with('getProjectManager')->get();
            }
            else if($duration == 1){
                return Project::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->with('getProjectManager')->get();
            }
            else if($duration == 2){
                return Project::whereYear('created_at', date('Y', strtotime('-1 year')))->with('getProjectManager')->get();
            }
            else{
                return Project::with('getProjectManager')->get();
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function selected(Request $request){
        try{
            return Project::with('getProjectRemark')->where('job', $request->old_id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            Project::where('job', $request->old_id)->update([
                'title' => $request->title,
                'location' => $request->location,
                'department_id' => (int)$request->department_id,
                'client' => $request->client,
                'assigned_manager' => $request->assigned_manager,
                'active' => $request->active,
            ]);

            ProjectRemark::where('project_id', $request->old_id)->delete();
            if(isset($request->remarks)){
                foreach ($request->remarks as $remark) {
                    ProjectRemark::create([
                        'code' => $remark['code'],
                        'remarks' => $remark['remark'],
                        'project_id' => $request->old_id
                    ]);
                }
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function delete(Request $request){
        try{
            return Project::where('job', $request->old_id)->delete();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function filterJob(Request $request){
        try{
            return Project::with('getProjectManager')->where('job', 'like', '%'.$request->job.'%')->get();
            
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function count(Request $request){
        return count(Project::all());
    }
}
