<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all() , [
            "name" => 'required' ,
            "email" => 'required|email|unique:users' ,
            "password"=> 'required' ,
            "image" => 'image | nullable' ,
            "age" => 'required' ,
            "number" => 'required' ,
            "address" => 'required' ,
            'roles' => 'required'
        ] ) ;

        if ($validate->fails()) {
            return response([
                'message' => "Error in data" ,
                'error' => $validate->errors()
                ] ) ;
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
            'message' => "done"
        ] ) ;
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $user = User::findOrFail($id) ;
        return $user ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
