<?php

namespace App\Http\Controllers\HSEModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ManDay;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManDayController extends Controller
{
    public function get(Request $request){
        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return ManDay::all();
            }
            else{
                return ManDay::where('user_id', Auth::user()->pf)->get();
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
            ManDay::create([
                'user_id' => Auth::user()->pf,
                'project_id' => $request->project_id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'days_lost' => $request->days_lost
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
            return ManDay::where('id', $request->id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            ManDay::where('id', $request->id)->update([
                'project_id' => $request->project_id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'days_lost' => $request->days_lost
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }
}
