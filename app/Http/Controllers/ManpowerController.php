<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Manpower;
use Illuminate\Support\Facades\Auth;
use Exception;

class ManpowerController extends Controller
{
    
    public function add(Request $request){
        try{
            Manpower::create([
                'project_id' => $request->project_id,
                'company' => $request->company,
                'type' => $request->type,
                'user_id' => Auth::user()->pf
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function get(){
        try{
            return Manpower::all();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function selected(Request $request){
        try{
            return Manpower::where('project_id', $request->old_id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            Manpower::where('project_id', $request->old_id)->update([
                'project_id' => $request->project_id,
                'company' => $request->company,
                'type' => $request->type
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function delete(Request $request){
        try{
            return Manpower::where('project_id', $request->project_id)->delete();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function type(Request $request){
        try{
            return Manpower::where('id', $request->company_id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function filterJob(Request $request){
        try{
            return Manpower::where('project_id', 'like', '%'.$request->job.'%')->get();
            
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function count(Request $request){
        return count(Manpower::all());
    }
}
