<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProject;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamEmail;

class UserController extends Controller
{
    public function index(){
        return '';
    }

    public function add(Request $request){
        $pass = Str::random(8);
        $hashed_random_password = Hash::make($pass);
        try{
            User::create([
                'pf' => $request->pf,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'position' => $request->position,
                'department_id' => (int)$request->department_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'type' => $request->type,
                'active' => $request->active,
                'password' => $hashed_random_password,
                'country' => $request->country,
                'city' => $request->city,
                'created_by' => Auth::user()->pf
            ]);

            foreach ($request->assigned_projects as $project) {
                UserProject::Create([
                    'user_id' => $request->pf,
                    'project_id' => $project
                ]);
            }

            $data = array(
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => $pass
            );
            Mail::to($request->email)->send(new TeamEmail($data));
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function user(Request $request){
        try{
            return $request->user();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function get(){
        try{
            return User::with('getUserProject')->where('pf', '!=', 'QHSE-Admin-1')->get();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function selected(Request $request){
        try{
            return User::with('getUserProject')->where('pf', $request->old_id)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function update(Request $request){
        try{
            User::where('pf', $request->old_id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'position' => $request->position,
                'department_id' => (int)$request->department_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'type' => $request->type,
                'active' => $request->active,
                'country' => $request->country,
                'city' => $request->city,
            ]);

            UserProject::where('user_id', $request->old_id)->delete();
            foreach ($request->assigned_projects as $project) {
                UserProject::create([
                    'user_id' => $request->old_id,
                    'project_id' => $project
                ]);
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
            return User::where('pf', $request->old_id)->delete();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }
}
