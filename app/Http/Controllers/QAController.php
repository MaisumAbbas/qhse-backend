<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QA;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class QAController extends Controller
{
    public function add(Request $request){
        try{
            QA::create([
                'user_id' => Auth::user()->pf,
                'project_id' => $request->project_id,
                'serial' => $request->serial,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'description' => $request->description,
                'status' => $request->status,
                'revision' => $request->revision,
                'form' => $request->form
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }

    public function get(Request $request){
        try{
            $pageNumber = $request->pageNumber;
            $limitStart = 0;
            $limitEnd = 6;
            if($pageNumber == 0){
                
            }
            else{
                $limitEnd = $limitEnd * $pageNumber;
                $limitStart = $limitEnd - 6;
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }

        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return QA::where([
                    ['form', $request->form]
                ])->skip($limitStart)->take(6)->get();
            }
            else{
                return QA::where([
                    ['form', $request->form], 
                    ['user_id', Auth::user()->pf]
                ])->skip($limitStart)->take(6)->get();
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function getMobileData(Request $request){
        try{
            $pageNumber = $request->pageNumber;
            $limitStart = 0;
            $limitEnd = 15;
            if($pageNumber == 1){
                
            }
            else{
                $limitEnd = $limitEnd * $pageNumber;
                $limitStart = $limitEnd - 15;
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }

        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return QA::where([
                    ['form', $request->form]
                ])->skip($limitStart)->take(15)->get();
            }
            else{
                return QA::where([
                    ['form', $request->form], 
                    ['user_id', Auth::user()->pf]
                ])->skip($limitStart)->take(15)->get();
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function all(Request $request){
        try{
            return QA::all();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }

    public function selected(Request $request){
        try{
            return QA::where('serial', $request->serial)->first();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }

    public function update(Request $request){
        try{
            QA::where('serial', $request->serial)->update([
                'project_id' => $request->project_id,
                'set_date' => Carbon::parse($request->set_date)->format('Y-m-d'),
                'description' => $request->description,
                'status' => $request->status,
                'revision' => $request->revision,
                'form' => $request->form
            ]);
            return QA::where('form', $request->form)->limit(10)->get();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }

    public function delete(Request $request){
        try{
            return QA::where('serial', $request->serial)->delete();
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);;
        }
    }

    public function statistics(Request $request){
        $user_type = Auth::user()->type;
        $duration = $request->duration;

        if($user_type == 'Manager'){
            if($duration == 0){
                $data = QA::whereDate('created_at', Carbon::today())->get()->groupBy(['form','status']);
            }
            else if($duration == 1){
                $data = QA::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get()->groupBy(['form','status']);
            }
            else if($duration == 2){
                $data = QA::whereYear('created_at', date('Y', strtotime('-1 year')))->get()->groupBy(['form','status']);
            }
            else{
                $data = QA::get()->groupBy(['form','status']);
            }
        }
        else{
            if($duration == 0){
                $data = QA::where('user_id', Auth::user()->pf)->whereDate('created_at', Carbon::today())->get()->groupBy(['form','status']);
            }
            else if($duration == 1){
                $data = QA::where('user_id', Auth::user()->pf)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get()->groupBy(['form','status']);
            }
            else if($duration == 2){
                $data = QA::where('user_id', Auth::user()->pf)->whereYear('created_at', date('Y', strtotime('-1 year')))->get()->groupBy(['form','status']);
            }
            else{
                $data = QA::where('user_id', Auth::user()->pf)->get()->groupBy(['form','status']);
            }
        }

        $form = ['RFI / IR', 'ITP', 'Method Statement', 'PQP', 'Internal NCR', 'External NCR'];
        $status = ['Approved', 'Approved With Comments', 'On Process', 'Cancelled', 'Rejected'];
        
        $jsonData = [
            'RFI / IR' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'ITP' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'Method Statement' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'PQP' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'Internal NCR' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'External NCR' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ]
        ];

        $i = 0;
        while($i<6){
            if(isset(($data->toArray())[$form[$i]])){
                $formData = ($data->toArray())[$form[$i]];
                $j = 0;
                while($j<5){
                    if(isset(($formData)[$status[$j]])){
                        $jsonData[$form[$i]]['Total'] = $jsonData[$form[$i]]['Total'] + count(($formData)[$status[$j]]);
                    }
                    if(isset(($formData)[$status[$j]])){
                        $formStatus = ($formData)[$status[$j]];
                        $jsonData[$form[$i]][$status[$j]] = count($formStatus);
                    }
                    $j=$j+1;
                }
            }
                $i=$i+1;
        }
        
        return response()->json($jsonData);
    }

    public function filterSerial(Request $request){
        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                return QA::where([
                    ['form', $request->form],
                    ['serial', 'like', '%'.$request->serial.'%']
                ])->get();
            }
            else{
                return QA::where([
                    ['form', $request->form],
                    ['serial', 'like', '%'.$request->serial.'%'],
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

    public function filterDuration(Request $request){
        $duration = $request->duration;
        try{
            $user_type = Auth::user()->type;
            if($user_type == 'Manager'){
                if($duration == 0){
                    return QA::where('form', $request->form)->whereDate('created_at', Carbon::today())->get();
                }
                else if($duration == 1){
                    return QA::where('form', $request->form)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();
                }
                else{
                    return QA::where('form', $request->form)->whereYear('created_at', date('Y', strtotime('-1 year')))->get();
                }
            }
            else{
                if($duration == 0){
                    return QA::where([
                        ['form', $request->form],
                        ['user_id', Auth::user()->pf]
                    ])->whereDate('created_at', Carbon::today())->get();
                }
                else if($duration == 1){
                    return QA::where([
                        ['form', $request->form],
                        ['user_id', Auth::user()->pf]
                    ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();
                }
                else{
                    return QA::where([
                        ['form', $request->form],
                        ['user_id', Auth::user()->pf]
                    ])->whereYear('created_at', date('Y', strtotime('-1 year')))->get();
                }
            }
        }
        catch(Exception $e){
            return response()->json([
                'error' => $e->getCode()
            ]);
        }
    }

    public function count(Request $request){
        $user_type = Auth::user()->type;
        if($user_type == 'Manager'){
            return count(QA::where('form', $request->form)->get());
        }
        else{
            return count(QA::where([
                ['form', $request->form],
                ['user_id', Auth::user()->pf]
            ])->get());
        }
    }

    public function projectStatistics(Request $request){
        $user_type = Auth::user()->type;
        $project_id = $request->project_id;

        if($user_type == 'Manager'){
            $data = QA::where('project_id', $project_id)->get()->groupBy(['form','status']);
        }
        else{
            $data = QA::where([
                ['project_id', $project_id],
                'user_id' => Auth::user()->pf
            ])->get()->groupBy(['form','status']);
        }

        $form = ['RFI / IR', 'ITP', 'Method Statement', 'PQP', 'Internal NCR', 'External NCR'];
        $status = ['Approved', 'Approved With Comments', 'On Process', 'Cancelled', 'Rejected'];
        
        $jsonData = [
            'RFI / IR' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'ITP' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'Method Statement' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'PQP' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'Internal NCR' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ],
            'External NCR' => [
                'Total' => 0,
                'Approved' => 0,
                'Approved With Comments' => 0,
                'On Process' => 0,
                'Cancelled' => 0,
                'Rejected' => 0
            ]
        ];

        $i = 0;
        while($i<6){
            if(isset(($data->toArray())[$form[$i]])){
                $formData = ($data->toArray())[$form[$i]];
                $j = 0;
                while($j<5){
                    if(isset(($formData)[$status[$j]])){
                        $jsonData[$form[$i]]['Total'] = $jsonData[$form[$i]]['Total'] + count(($formData)[$status[$j]]);
                    }
                    if(isset(($formData)[$status[$j]])){
                        $formStatus = ($formData)[$status[$j]];
                        $jsonData[$form[$i]][$status[$j]] = count($formStatus);
                    }
                    $j=$j+1;
                }
            }
            $i=$i+1;
        }

        return response()->json($jsonData);
    }
}
