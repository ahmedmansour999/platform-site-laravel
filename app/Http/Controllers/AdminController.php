<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index($id)
    {
        $admins = User::where('roles', 'control')
        ->where('id', '!=', $id)
        ->get();

    return $admins;
    }


    public function show($id)
    {
        $admin = User::where('id', $id)->first() ;
        return $admin;
    }



    public function update(Request $request,  $id)
    {
        $admin = User::findOrFail($id);
        $validate = Validator::make(
            $request->all() ,
            [
                'name' => 'required',
                'email' => 'required | unique:users,email',
                'password' => "required",
                'address'=> "nullable"
            ],
            [
                "name.required" => 'name is required',
                "email.required" => 'email is required',
                "password.required" => 'password is required',
                "email.unique" => 'email is already used',
            ]
        );

        if ($validate->fails()) {
            return response([
                'error' => $validate->errors()
            ]);
        }
        if ($request->image != null) {
            $extension = $request->image->getClientOriginalExtension();
            $fileName = now()->timestamp . '.' . $extension;

            $path = $request->file('image')->storeAs('image' , $fileName , 'public');
        }else{
            $fileName = $request->image ;
        }
        $admin->update([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password),
            'image' => $fileName  ,
            'age' => $request->age ,
            'number' => $request->number ,
            'address' => $request->address ,
        ]) ;
        return response(['message' => 'update Success']) ;
    }


    public function destroy($id){
        $admin = User::findOrFail($id) ;
        $admin->delete() ;
        return "Deleted Successfully" ;
    }

}
