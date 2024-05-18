<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecture = Lecture::with('lecturer.user')->get() ;
        return $lecture ;
    }

    public function lecturerLPdf($id){

        $lecture = Lecture::where('lecturer_id' ,$id)->get() ;
        return $lecture ;
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
            'description' => 'required|string',
            'lectures' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
            'lecturer_id' => 'required'
        ]);

        if ($request->hasFile('lectures')) {
            $uploadedFile = $request->file('lectures');
            $extension = $uploadedFile->getClientOriginalExtension();
            $fileName = now()->timestamp . '.' . $extension;

            $path = $uploadedFile->storeAs('lectures', $fileName, 'public');

            $lecture = Lecture::create([
                'title' => $request->title,
                'description' => $request->description,
                'lectures' => $fileName,
                'lecturer_id' => $request->lecturer_id
            ]);

            return response(['message' => "Success Uploaded"]);
        } else {
            return response(['message' => "No file uploaded"], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lecture = Lecture::find($id) ;
        return $lecture ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecture $lecture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateLecture(Request $request, $id)
    {
        $lectures = Lecture::findOrFail($id);
        // Check if a new video file is uploaded
        if ($request->hasFile('lectures')) {
            $uploadedFile = $request->file('lectures');
            $extension = $uploadedFile->getClientOriginalExtension();
            $fileName = now()->timestamp . '.' . $extension;
            $path = $uploadedFile->storeAs('lectures', $fileName, 'public');
            $lectures->update([
                'title' => $request->title,
                'description' => $request->description,
                'lectures' => $fileName,
            ]);
        } else {

            $lectures->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

        }

        return response(['message' => "Success Uploaded"]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lecture = Lecture::find($id) ;
        $lecture->delete() ;
        return response(['message' => "Success deleted"]);

    }
}
