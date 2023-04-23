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
            $details = Attendance::where('atten_date', $request->atten_date)->get();
            if(sizeof($details)>0){
            Attendance::where('atten_date', $request->atten_date)->update(['punch_out'=>date('H:i:s'),'lat'=>$request->lat,'long'=>$request->long]);
            $x=['punch_out'=>date('H:i:s'),'atten_date' => $request->atten_date,'punch_in'=>$details[0]->punch_in];
            DB::commit();
                return Response(['message' => 'updated successfully','status'=>1,'data'=>$x],200);
            }
            if(str_starts_with($request->member_code, 'AF')){
            $member_type='student';
            }else{
            $member_type='staff';
            }
            $attn_type='present';
            $postParameter = ['user_id' => $request->user_id,'atten_date' => $request->attend_date,'punch_in'=>date('H:i:s'),'lat'=>$request->lat,'long'=>$request->long,'member_id'=>$request->member_id,'member_code'=>$request->member_code,'status'=>0,'transfer_status'=>0,'atten_type'=>$attn_type,'member_type'=>$member_type];
            Attendance::create($postParameter);
            $curlHandle = curl_init('https://cmis3api.anudip.org/api/insertFromAttenApp');
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $postParameter);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = curl_exec($curlHandle);
            //dd($curlResponse);
            curl_close($curlHandle);
            $x=['punch_in'=>date('H:i:s'),'atten_date' => date('Y-m-d')];
            DB::commit();
            return Response(['message' => 'inserted successfully','status'=>1,'data'=>$x],200);

        } catch (Exception $e) { 
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function fetchAttendance($user_id)
    {
        //
        $details = Attendance::where('atten_date', date('Y-m-d'))->where('user_id',$user_id)->get();
        if(sizeof($details)>0){
            $x=['punch_in'=>$details[0]->punch_in,'punch_out'=>$details[0]->punch_out,'atten_date'=>$details[0]->atten_date];
        }
        else{
            $x=[];
        }
        return Response(['datas' => $x,'status'=>1],200);
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
