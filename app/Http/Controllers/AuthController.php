<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;



class AuthController extends Controller
{


    public function Register(Request $request){

        $validate = Validator::make($request->all() , [
            "name" => 'required' ,
            "email" => 'required|email|unique:users' ,
            "password"=> 'required' ,
            "age" => 'required' ,
            "number" => 'required' ,
            "address" => 'required' ,
            'roles' => 'required'
        ] ) ;

        if ($validate->fails()) {
            return response([
                'message' => "Error in Register" ,
                'error' => $validate->errors()
                ] , Response::HTTP_UNAUTHORIZED ) ;
        }

        // create student table


        if ($request->image != null) {
            $extension = $request->image->getClientOriginalExtension();
            $fileName = now()->timestamp . '.' . $extension;

            $path = $request->file('image')->storeAs('image' , $fileName , 'public');
        }else{
            $fileName = $request->image ;
        }


        $user =  User::create([

            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password),
            'image' => $fileName  ,
            'age' => $request->age ,
            'number' => $request->number ,
            'address' => $request->address ,
            'roles' => $request->roles ,
        ]
        ) ;

        $user->years()->attach($request->years) ;

        $token = $user->createToken('token')->plainTextToken;


        if ($request->roles == 'student') {
            $student = Student::create([
                'id' => $user->id ,
                'user_id' => $user->id
            ]) ;

        }elseif ($request->roles == 'lecturer') {
            $lecturer = Lecturer::create([
                'id' => $user->id ,
                'specialist'=>$request->specialist ,
                'user_id' => $user->id
            ]) ;
        }


        return response([
            'message' => "congratulation register done" ,
            "token" => $token ,
            "id" => $user->id ,
            'role' => $user->roles
        ] ) ;
    }

    public function Login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            $error = "";
            if (!User::where('email', $request->email)->exists()) {
                $error = "User not found";
            } elseif (!User::where('email', $request->email)->where('password', Hash::make($request->password))->exists()) {
                $error = "Incorrect password";
            }

            return response([
                'message' => "Invalid login",
                "error" => $error
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('token')->plainTextToken;

        return response([
            "message" => "Welcome, {$user->name}",
            "token" => $token ,
            "id" => $user->id ,
            'role' => $user->roles ,
        ] ) ;
    }

    public function Logout(Request $request){

        Auth::logout() ;

        return response([
            "message" => "logout Successfully"
        ]);
    }


}
