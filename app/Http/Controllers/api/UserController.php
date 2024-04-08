<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Validator;
use DB;

class UserController extends Controller
{
    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
   
        if($validator->fails()){

            return Response(['message' => $validator->errors()],401);
        }
        $anudip = strpos(strtoupper($request->username), 'ANP');
        //dd($anudip);
        if($anudip !== false ){
            $user_id_count=DB::table('users')
            ->where('username', $request->username)
            ->count();
            if($user_id_count==0){
                
                //if($anudip !== false ){
                    $details_from_cmis= DB::connection('mysql_2')->table('users as u')
                    ->leftJoin('users_roles as ur', 'u.id', '=', 'ur.user_id')
                    ->leftJoin('roles as r', 'r.id', '=', 'ur.role_id')
                    ->leftJoin('members as m', 'u.member_id', '=', 'm.id')
                    ->where('u.user_id', strtoupper($request->username))
                    ->where('ur.status', 1)
                    ->distinct('ur.role_id')
                    ->get(['m.first_name as first_name','m.last_name as last_name','u.user_id as user_id','u.email as email','u.password as password','r.id as role_id','r.name as role_name','m.mobile_no as mobile_no']);
                    //dd($details_from_cmis);
                    if(sizeof($details_from_cmis)>0){
                        DB::table('users')->insert([
                            'name' => $details_from_cmis[0]->first_name." ".$details_from_cmis[0]->last_name,
                            'username' =>  $details_from_cmis[0]->user_id,
                            'email' => $details_from_cmis[0]->email,
                            'mobile_no' => $details_from_cmis[0]->mobile_no,
                            'password' => $details_from_cmis[0]->password,
                            'status' => 1,
                            'role_name' => 'trainer',
                        ]);
                    }else{
                        return response(['status'=>0,'message' => "Incorrect Id or Password"], 400);
                    }
                    
                //}

            }
        }   
   
        if(Auth::attempt($request->all())){

            $user = Auth::user(); 
    
            $success =  $user->createToken('MyApp')->plainTextToken; 
        
            return Response(['token' => $success,'status'=>1,'id'=>Auth::user()->id],200);
            //return $this->sendResponse(['token' => $success,'status'=>1], 'Login Success');
        }

        return Response(['message' => 'user_id or password wrong','status'=>0],401);
    }

    /**
     * Fetch user details after login.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
     * Display the specified resource.
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
        
        return Response(['data' => 'User Logout successfully.'],200);
    }
}
