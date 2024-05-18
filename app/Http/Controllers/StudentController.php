<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::with('user')->get() ;
        return $student ;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::findOrFail($id)->with('user')->first() ;
        return $student ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'number' => $request->number,
            'address' => $request->address,
            'about' => $request->about,
        ]);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image') ;
            $extension = $uploadedFile->getClientOriginalExtension() ;
            $fileName = now()->timestamp. '.' . $extension ;
            $path = $uploadedFile->storeAs('image' ,$fileName , 'public' ) ;
            $user->update([
                'image' => $fileName,
            ]);

        }

        $user->save();

        return response([
            'update' => "successfully Update",
            "data" => $user
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id) ;
        $student->delete() ;
    }
}
