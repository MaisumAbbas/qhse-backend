<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use URL;

class ProfileController extends Controller
{
    public function edit(Request $request){
        $storagePath = Storage::disk('public')->put('profile/', $request->file('picture'));
        $storageName = basename($storagePath);
        try{
            User::where('pf', Auth::user()->pf)->update([
                'picture' => URL::to('/').'/storage/profile/'.$storageName,
            ]);
            return User::where('pf', Auth::user()->pf)->get();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }

    public function update(Request $request){
        try{
            User::where('pf', Auth::user()->pf)->update([
                'phone' => $request->phone,
                'about' => $request->about,
                'dob' => Carbon::parse($request->dob)->format('Y-m-d'),
            ]);
            return User::where('pf', Auth::user()->pf)->get();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }
}
