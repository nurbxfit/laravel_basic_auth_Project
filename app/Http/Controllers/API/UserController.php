<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $sucessStatus = 200;

    //login API
    public function login(){


        //check if email send by post request maches the email in database (using auth automatically)
        if(Auth::attempt([
            'email'=>request('email'),
            'password'=>request('password'),
            ])){
                //authenticate user.
                $user = Auth::user();
                $sucess['token'] = $user->createToken('epic-ec-app')->accessToken; //generate new token with name 'epic-ec-app'

                //return response to app in json format
                return response()->json(
                    ['sucess'=>$sucess],
                    $this->sucessStatus
                );
            }else{
                //else the login attempt unsuccess
                return response()->json(
                    ['error'=>'Login Unsucess'],
                    401 //error code for unauthorised
                );
            }
    }



    //REGISTER API
    public function register(Request $request){
        
        //using validator to validate the request form
        $validator = Validator::make($request->all(),
            [
                'name'       =>'required',
                'email'      => 'required',
                'password'   => 'required',
                'c_password' => 'required|same:password', //required or same as password
            ]
        );

        //check if validation fails

        if($validator->fails()){
            return response()->json(
                ['error'=>$validator->errors()],
                401, //code unauthorize
            );
        }
        else{
            //we create new user
            //$password = bycrypt($request['password']);
            try{
                $user = User::create([
                    'name'      => $request['name'],
                    'email'     => $request['email'],
                    'password'  => bcrypt($request['password']),
                ]);
                $success['token']   =  $user->createToken('epic-ec-app')-> accessToken;
                $sucess['name']     =  $user->name;
    
                //return success response
                return response()->json(
                    ['success'=>$success],
                    $this->sucessStatus
                );
            }catch (\Exception $e){
                return response()->json(
                    ['error'=>$e,
                     'message:'=>'Email Existed',
                    ],

                );
            }

        }

    }

    //USER DETAILS API 
    public function details(){
        $user = Auth::user(); //get authenticated user
        return response()->json(
            ['success'=>$user],
            $this->sucessStatus,
        );
    }

    //Logout API, Revoke the token
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(
            ['message'=>'You are now Logged Out'],
            $this->sucessStatus,
        );
    }
}
