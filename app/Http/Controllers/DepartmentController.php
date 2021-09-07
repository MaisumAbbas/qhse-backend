<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Exception;

use function GuzzleHttp\Promise\all;

class DepartmentController extends Controller
{
    public function users(Request $request){
        try{
            return User::where('department_id', $request->department_id)->get();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }
}
