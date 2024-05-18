<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
{
    public function index(){
        $years = Year::all() ;
        return $years ;
    }

    public function show( $id ){
        $year = Year::findOrFail($id) ;
        return $year ;
    }

    public function store(Request $request){


      $validator = Validator::make($request->all(), [
            'year' => " required | string | min:3 | unique:years,year"
        ], [
            'year.required' => 'year is required' ,
            'year.string' => 'year is unValid' ,
            'year.length' => 'min length is 3 char' ,
            'year.unique' => 'year is already exist' ,
        ]);


        if ($validator->fails()) {
            return $validator->errors() ;
        }

        Year::create($request->all()) ;
        return response([
            'message' => 'create Succeessful'
        ]) ;

    }

    public function update(Request $request , $id){

        $year = Year::findOrFail($id) ;
        $validator = Validator::make($request->all(), [
            'year' => " required | string | min:3 | unique:years,year"
        ], [
            'year.required' => 'year is required' ,
            'year.string' => 'year is unValid' ,
            'year.length' => 'min length is 3 char' ,
            'year.unique' => 'year is already exist' ,
        ]);

        if ($validator->fails()) {
            return $validator->errors() ;
        }
        $year->update([
            "year" => $request->year
        ]) ;


        return response()->json([
            'message' => 'updated Successfully '
        ]) ;

    }
    public function destroy($id){
        $year = Year::findOrFail($id) ;
        $year->delete() ;
        return response([
            'message' => "Deleted Successfully"
        ]) ;
    }

}
