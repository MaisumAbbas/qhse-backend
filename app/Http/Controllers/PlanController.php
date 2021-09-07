<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Plan;
use Exception;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function get(Request $request){
        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return Plan::where('plan', $request->plan)->get();
            }
            else{
                return Plan::where([
                    ['plan', $request->plan], 
                    ['user_id', Auth::user()->pf]
                ])->get();
            }  
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function add(Request $request){
        try{
            Plan::create([
                'user_id' => Auth::user()->pf,
                'project_id' => $request->project_id,
                'ref' => $request->ref,
                'remark' => $request->remark,
                'plan' => $request->plan
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function selected(Request $request){
        try{
            return Plan::where('ref', $request->ref)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            Plan::where('ref', $request->ref)->update([
                'project_id' => $request->project_id,
                'remark' => $request->remark
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }
}
