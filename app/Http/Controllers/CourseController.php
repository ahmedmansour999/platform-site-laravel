<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Course_Content;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = Course::with('lecturer.user')->get() ;
        return $course ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function lecturerCourse($id){
        $course = Course::with('contents')->where('lecturer_id' , $id)->get() ;
        return $course ;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $validatedData = $request->validate([
                'course_name' => 'required',
                'price' => 'required',
                'lecturer_id' => 'required',
                'duration'=>"required" ,
                'image' => 'required|file|mimes:png,jpg,jpeg,gif,bmp'
            ]);

            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image') ;
                $extension = $uploadedFile->getClientOriginalExtension() ;
                $fileName = now()->timestamp. '.' . $extension ;
                $path = $uploadedFile->storeAs('image' ,$fileName , 'public' ) ;
                $course = Course::create([
                    'course_name' => $validatedData['course_name'],
                    'price' => $validatedData['price'],
                    'lecturer_id' => $validatedData['lecturer_id'],
                    'duration' => $validatedData['duration'],
                    'image' => $fileName
                ]);
            }else{
                return response([
                    'message' => 'Enter Valid Image'
                ]) ;
            } ;



        }catch(ValidationException $e){
            return response()->json(['error' => $e->validator->errors()->first()], 422);

        };
        return response([
            'message' => "added Successfully "
        ]) ;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::with('contents')->where('id' , $id)->get() ;
        return $course ;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $course = Course::findOrFail($id) ;
        try{

            return $request->file('course_name') ;

            $validatedData = $request->validate([
                'course_name' => 'required',
                'price' => 'required',
                'duration'=>"required" ,
            ]);

            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image') ;
                $extension = $uploadedFile->getClientOriginalExtension() ;
                $fileName = now()->timestamp. '.' . $extension ;
                $path = $uploadedFile->storeAs('image' ,$fileName , 'public' ) ;
                $course->update([
                    'course_name' => $request->course_name,
                    'price' => $validatedData['price'],
                    'duration' => $validatedData['duration'],
                    'image' => $fileName
                ]);
            }else{
                $course->update([
                    'course_name' => $validatedData['course_name'],
                    'price' => $validatedData['price'],
                    'duration' => $validatedData['duration'],
                ]);
            } ;



        }catch(ValidationException $e){
            return response()->json(['error' => $e->validator->errors()->first()], 422);

        };
        return response([
            'message' => "added Successfully "
        ]) ;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::find($id) ;
        $course->delete() ;
        return response(['message' => "Success deleted"]);

    }
}
