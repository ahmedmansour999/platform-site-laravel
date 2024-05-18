<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::all() ;
        return $cart ;
    }

    // Get User Cart
    public function Usercart($id){
        $carts = Cart::with('courses')->where('user_id', $id)->get();
        return $carts ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all() , [
            "user_id" => 'required' ,
            "course_id" => "required"
        ] , [
            "user_id.required" => "user is required" ,
            "course_id.required" => "course is required"
        ] ) ;

        if ($validate->fails()) {

            return response([
                'message' => "Failed" ,
                "error" => $validate->errors()
            ]) ;
        }

        Cart::create($request->all()) ;
        return "Created Successfully" ;

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $card = Cart::where('id' , $id) ;
        $card->delete() ;
        return "deleted Successfully" ;
    }
}
