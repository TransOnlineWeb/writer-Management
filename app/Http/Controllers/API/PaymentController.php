<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Wallet;
use App\WalletTransaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earnings = Wallet::all();
        $earn = array();
        foreach ( $earnings as $earning ){
            $writer_name = User::where('id',$earning['user_id'])->value('name');
            $amount = $earning['amount'];
            $user_id = $earning['user_id'];
            $earns = array(
                'writer_name'=> $writer_name,
                'amount' => $amount,
                'user_id' => $user_id,
            );
            array_push( $earn, $earns);
        }
        return['earning'=> $earn];
    }
    public function myearnings($userId){
        $myearnings = WalletTransaction::where('user_id',$userId)->where('type',0)->get();
        $myearn = array();
         foreach ($myearnings as $myearning){
            $title = Order::where('id',$myearning['order_id'])->value('title');
            $completed = File::where('order_id',$myearning['order_id'])->where('isComplete',1)->value('created_at');
            $oderId = Order::where('id',$myearning['order_id'])->value('order_number');
            $pages = Order::where('id',$myearning['order_id'])->value('pages');
            $amount_payable = WalletTransaction::where('order_id',$myearning['order_id'])->where('type',0)->value('amount');
            $penalty = WalletTransaction::where('order_id',$myearning['order_id'])->where('type',1)->value('amount');
            $earning = $amount_payable + $penalty;
            $earners =array(
                'title' => $title,
                'completed_time' => $completed,
                'orderId'=> $oderId,
                'pages'=> $pages,
                'amount_payable'=> $amount_payable,
                'penalty'=> $penalty,
                'earning' => $earning,
            );
            array_push($myearn,$earners);
        }
         return ['myearnings'=> $myearn];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
