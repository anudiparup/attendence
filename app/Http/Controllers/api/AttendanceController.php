<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAttendance(Request $request)
    {
        
         DB::beginTransaction();
         try { 
                 date_default_timezone_set('Asia/Calcutta');
                 $details = Attendance::where('atten_date', date('Y-m-d'))->get();
                 if(sizeof($details)>0){
 
                     $option = Attendance::where('atten_date', '=', date('Y-m-d'))->get();
                 
                     $option->lat = $request->lat;
                     $option->long = $request->long;
                     $option->punch_out = date('H:i:s');
                     $option->save();
                     $this->sendResponse(['message' => 'Updated successfully','status'=>1], 'Updated successfully');
                 }
             $data = new Attendance;
     
             $data->user_id = $request->user_id;
             $data->atten_date = date('Y-m-d');
             $data->punch_in = date('H:i:s');
             //$data->punch_out = date('H:i:s');
             $data->lat = $request->lat;
             $data->long = $request->long;
             $data->save();
             $this->sendResponse(['message' => 'inserted successfully','status'=>1], 'inserted successfully');
 
         } catch (Exception $e) { 
             DB::rollback();
             return $this->sendError($e->getMessage());
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
