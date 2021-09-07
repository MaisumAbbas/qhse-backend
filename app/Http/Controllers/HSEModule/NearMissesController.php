<?php

namespace App\Http\Controllers\HSEModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NearMiss;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NearMissesController extends Controller
{
    public function get(Request $request){
        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return NearMiss::all();
            }
            else{
                return NearMiss::where('user_id', Auth::user()->pf)->get();
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
            NearMiss::create([
                'user_id' => Auth::user()->pf,
                'project_id' => $request->project_id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'description' => $request->description,
                'remark' => $request->remark
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
            return NearMiss::where('id', $request->id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            NearMiss::where('id', $request->id)->update([
                'project_id' => $request->project_id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'description' => $request->description,
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
