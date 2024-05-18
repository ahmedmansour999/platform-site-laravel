<?php

namespace App\Http\Controllers;

use App\Models\Vedio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VedioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $vedios = Vedio::where('lecturer_id', $id)->get();

        if ($vedios->isEmpty()) {
            return response()->json(['message' => 'No videos found for the specified lecturer ID'], 404);
        }

        // If videos are found, return them
        return response()->json($vedios);
    }

    public function AllVedio(){
        $vedio = Vedio::with('Lecturer.user' )->get() ;
        return $vedio ;
    }

    public function vedioLecturer($id)
    {
        $vedios = Vedio::where('lecturer_id', $id)->get();

        if ($vedios->isEmpty()) {
            return response()->json(['message' => 'No videos found for the specified lecturer ID'], 404);
        }

        // If videos are found, return them
        return response()->json($vedios);
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



        $this->validate($request, [
            'title' => 'required|string|max:255',
            'vedio' => 'required|file|mimetypes:video/*',
            'lecturer_id' => 'required'
        ]);


        $uploadedFile = $request->file('vedio');

        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = now()->timestamp . '.' . $extension;

        $path = $request->file('vedio')->storeAs('vedio' , $fileName , 'public');

        $vedio = Vedio::create([
            'title' => $request->title ,
            'description'=>$request->description ,
            'vedio' => $fileName ,
            "lecturer_id" => $request->lecturer_id
        ]) ;

        return response([
            'message' => "success Uploaded" ,
        ]) ;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vedio = Vedio::where('id' , $id)->first() ;
        return $vedio ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vedio $vedio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateVedio(Request $request, $id)
    {


        $vedio = Vedio::findOrFail($id);

        if ($request->hasFile('vedio')) {
            $uploadedFile = $request->file('vedio');
            $extension = $uploadedFile->getClientOriginalExtension();
            $fileName = now()->timestamp . '.' . $extension;
            $path = $uploadedFile->storeAs('vedio', $fileName, 'public');
            $vedio->update([
                'title' => $request->input('title') ,
                'description' => $request->input('description') ,
                'vedio' => $fileName ,
                'lecturer_id' => $request->input('lecturer_id')
            ]);
        } else {
            $vedio->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'lecturer_id' => $request->input('lecturer_id')
            ]);
        }

        return response(['message' => "Success Uploaded"]);

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vedio = Vedio::find($id) ;
        $vedio->delete() ;
        return response(['message' => "Success deleted"]);

    }
}
