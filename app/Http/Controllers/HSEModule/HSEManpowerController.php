<?php

namespace App\Http\Controllers\HSEModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HSEManpower;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HSEManpowerController extends Controller
{
    public function add(Request $request){
        try{
            HSEManpower::create([
                'user_id' => Auth::user()->pf,
                'company_id' => $request->id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'no_manpower' => $request->no_manpower
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function get(Request $request){
        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return HSEManpower::with('getManpower')->get();
            }
            else{
                return HSEManpower::with('getManpower')->where('user_id', Auth::user()->pf)->get();
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
            return HSEManpower::where('id', $request->id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            HSEManpower::where('id', $request->id)->update([
                'company_id' => $request->company_id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'no_manpower' => $request->no_manpower
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }
}
