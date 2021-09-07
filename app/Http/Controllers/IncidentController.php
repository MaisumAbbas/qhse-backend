<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\IncidentType;
use App\Models\IncidentIntensity;
use Illuminate\Support\Facades\Auth;
use Exception;

class IncidentController extends Controller
{
    // Incident General 

    // Incident Type

    public function addType(Request $request){
        try{
            IncidentType::create([
                'user_id' => Auth::user()->pf,
                'type' => $request->type
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    // Incident Intensity
}
