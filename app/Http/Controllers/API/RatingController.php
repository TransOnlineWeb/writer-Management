<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getRate($orderId)
    {
        return Rating::where('order_id',$orderId)->count();

    }

    public function getMyRate($orderId)
    {
        $rate = Rating::where('order_id',$orderId)->count();
        if($rate != 0){
            return Rating::where('order_id', $orderId)->value('rating');
        }else{
            return 0;
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $rating = Rating::create([
           'order_id' => $request->OrderId,
           'user_id' => $request->UserId,
           'rating' => $request ->Rating,
       ]);
        return response()->json($rating);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
