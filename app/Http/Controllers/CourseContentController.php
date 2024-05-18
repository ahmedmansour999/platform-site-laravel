<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course_Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CourseContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $content = Course_Content::with('vedio', 'lecture' , 'course.lecturer.user' )->orderBy('order' , 'ASC')->get() ;
        return $content ;
    }

    public function courseContent($id){
        $content = Course_Content::with('vedio', 'lecture')->orderBy('order' , 'ASC')->where('course_id' , $id)->get() ;
        return $content ;
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
        try {
            $validatedData = $request->validate([
                'course_id' => 'required',
                'content_type' => 'required',
                'order' => 'required',
                'lecture_id' => 'nullable|exists:lectures,id',
                'vedio_id' => 'nullable|exists:vedios,id',
            ]);

            Course_Content::where('course_id', $request->course_id)
            ->where('order', '>=', $request->order)
            ->increment('order');

            $content = Course_Content::create([
                'lecture_id' => $request->lecture_id,
                'vedio_id' => $request->vedio_id,
                'course_id' => $request->course_id,
                'content_type' => $request->content_type,
                'order' => $request->order,
            ]);

            return $content;
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
    {
        $content = Course_Content::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'course_id' => 'required',
                'content_type' => 'required',
                'order' => 'required',
                'lecture_id' => 'nullable|exists:lectures,id',
                'vedio_id' => 'nullable|exists:vedios,id',
            ]);

            $previousOrder = $content->order;
            $newOrder = $request->order;

            if ($newOrder > $previousOrder) {
                Course_Content::where('course_id' , $content->course_id )
                ->where('order' , '>' , $previousOrder )
                ->where('order' , '<=' , $newOrder )
                ->decrement('order') ;
            } elseif ($newOrder < $previousOrder) {
                Course_Content::where('course_id', $content->course_id)
                    ->where('order', '>=', $newOrder)
                    ->where('order', '<', $previousOrder)
                    ->increment('order');
            }


            $content->update([
                'lecture_id' => $request->lecture_id,
                'vedio_id' => $request->vedio_id,
                'course_id' => $request->course_id,
                'content_type' => $request->content_type,
                'order' => $request->order,
            ]);

            $content->save();
            return $content;
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $content = Course_Content::find($id) ;
        $content->delete() ;
        return response(['message' => "Success deleted"]);

    }
}
