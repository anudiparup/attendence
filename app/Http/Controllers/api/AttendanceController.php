<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use DB;
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
 
                    Attendance::where('atten_date', date('Y-m-d'))->update(['punch_out'=>date('H:i:s'),'lat'=>$request->lat,'long'=>$request->long]);
                     return Response(['message' => 'updated successfully','status'=>1],200);
                 }
                 Attendance::create(['user_id' => $request->user_id,'atten_date' => date('Y-m-d'),'punch_in'=>date('H:i:s'),'lat'=>$request->lat,'long'=>$request->long,'member_id'=>$request->member_id]);
             
                // $this->sendResponse(['message' => 'inserted successfully','status'=>1], 'inserted successfully');
                DB::commit();
                return Response(['message' => 'inserted successfully','status'=>1],200);
 
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
