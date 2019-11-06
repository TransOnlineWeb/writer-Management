<?php

namespace App\Http\Controllers\API;

use App\Bid;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
    }

    public function makeBid($orderId)
    {
        $ifBid = Bid::where('user_id', auth()->user()->id)->where('order_id', $orderId)->count();

        if ($ifBid == 0) {
            $bid = new Bid();
            $bid->order_id = $orderId;
            $user = auth()->user()->id;
            $bid->user_id = $user;
            $bid->status = 0;
            $bid->save();

            return response(['status' => 'success'], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'You already placed a bid',
            ], 422);
        }
    }

    public function checkBid($orderId)
    {
        return Bid::where('user_id', auth()->user()->id)->where('order_id', $orderId)->count();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        $bids = Bid::where('order_id', $orderId)->latest()->get();
        $parent = array();

        foreach ($bids as $bid) {
            $name = User::where('id', $bid['user_id'])->value('name');
            $email = User::where('id', $bid['user_id'])->value('email');
            $phone = User::where('id', $bid['user_id'])->value('phone_number');
            $level_id = User::where('id', $bid['user_id'])->value('level_id');

            $child = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'id' => $bid['id'],
                'level' => $level_id,
                'status' => $bid['status']
            );

            array_push($parent, $child);
        }

        return $parent;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
