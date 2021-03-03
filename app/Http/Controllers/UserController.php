<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Models\User;


//all references available on laravel 8.x docs Authentication
//and tymon/jwt-auth official page
class UserController extends Controller
{
    //


    public function authenticate(Request $request){

        $credentials=$request->only(['email','password']);
        //return response($credentials);
        if(!$token=Auth::attempt($credentials)){
        return response($token,404);
        }
         return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
        
    }
    public function me(Request $request){

        return response()->json(auth()->user());
    }

    public function RegisterUser(Request $request){


        //here we validate post data

        $validation=Validator::make($request->all(),[
            'name'=>'required|string |min:3 |max:20',
            'email'=>'required|email|unique:users',
            'password'=>'required|max:8'
        ]);



        if($validation->fails()){

            $errors=$validation->errors();
            return response()->json(['errors'=>$errors,'status'=>403],200);

        }


    




     //after validation here tried to insert database
     //and handled database exception like duplicatekey

      try{

           $new_user=User::create([
            'name'=>$request->input('name'),
            'password'=>Hash::make($request->input('password')),
            'email'=>$request->input('email'),
           ] );
           return response()->json([
            'Message'=>$new_user->name.'registered successfully',
            'status'=>200
           ],200);

        }catch(Exception $e){ //here  Illuminate\Database\QueryException  can occur
            return response()->json([
            'Message'=>'cant register user'
            ],403);
        }catch(QueryException $e){ //here database query exception caugth
            return response()->json([
                'Message'=>'cant register user'
            ],403);
        }

        

        


    }



}
