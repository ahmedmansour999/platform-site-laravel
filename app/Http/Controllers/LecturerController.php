<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturer = Lecturer::with('user', 'vedios')->get();
        return $lecturer;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lecturer = Lecturer::where('id', $id)->with('user', 'vedios')->get();
        return $lecturer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::where('id', $id)->with('user')->first();
        $user = User::where('id', $id)->first();

        $lecturer->update([
            'specialist' => $request->specialist,
            'graduate' => $request->graduate
        ]);



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

        $lecturer->save();
        $user->save();

        return response([
            'update' => "successfully Update",
            "data" => $lecturer
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lecturer = User::findOrFail($id);
        $lecturer->delete();
    }
}
