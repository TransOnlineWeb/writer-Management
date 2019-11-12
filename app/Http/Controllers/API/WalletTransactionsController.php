<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Wallet;
use App\WalletTransaction;
use Illuminate\Http\Request;

class WalletTransactionsController extends Controller
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

    public function walletBalance()
    {
        $user = auth()->user()->id;

        return User::find($user)->wallet;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function isVerified($orderId)
    {
        // Change status to completed
        $theOrder = Order::findOrFail($orderId);
        $theOrder->status = 5;
        $theOrder->update();

        // get order details
        $order = Order::where('id', $orderId)->first();

        // Check if Writer has a wallet
        $ifWalletExists = Wallet::where('user_id', $order['assigned_user_id'])->count();

        if ($ifWalletExists > 0) {
            // Update wallet
            $myWallet = Wallet::where('user_id', $order['assigned_user_id'])->first();
            $wallet = Wallet::findOrFail($myWallet['id']);
            $wallet->amount = $wallet['amount'] + $order['total_amount'];
            $wallet->update();
        } elseif ($ifWalletExists == 0) {
            // Create wallet as wallet does not exist
            $wallet = new Wallet();
            $wallet->user_id = $order['assigned_user_id'];
            $wallet->amount = $order['total_amount'];
            $wallet->save();
        }

        $transaction = new WalletTransaction();
        $transaction->user_id = $order['assigned_user_id'];
        $transaction->type = 0;
        $transaction->order_id = $orderId;
        $transaction->order_number = $order['order_number'];
        $transaction-> amount = $order['total_amount'];
        $transaction->save();

        return response(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showTransactions()
    {
        return WalletTransaction::where('user_id', auth()->user()->id)->paginate(10);
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
