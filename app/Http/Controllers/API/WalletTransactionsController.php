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
        $transaction->amount = $order['total_amount'];
        $transaction->balance = User::find($order['assigned_user_id'])->wallet->amount;
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
        return WalletTransaction::where('user_id', auth()->user()->id)->latest()->paginate(10);
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

    public function pay(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'Paymethod' => 'required',
        ]);
        $myWallet = Wallet::WHERE('user_id', $request->id)->first();
        $wallet = Wallet::findOrFail($myWallet['id']);
        $wallet->amount = $myWallet['amount'] - $request->amount;
        $wallet->save();

        $transaction = new WalletTransaction();
        $transaction->user_id = $request->id;
        $transaction->Payment_method = $request->Paymethod;
        $transaction->amount = $request->amount;
        $transaction->type = 3;
        $transaction->balance = User::find($request->id)->wallet->amount;
        $transaction->save();

        return response(['status' => 'success'], 200);
    }

    public function fine(Request $request)
    {
        $request->validate([
            'percentage' => 'required',
            'description' => 'required',
        ]);

        $theOrder = Order::findOrFail($request->orderId);
        $totalAmount = $theOrder['total_amount'];
        $fineAmount = ($request->percentage / 100) * $totalAmount;

        $ifWalletExists = Wallet::where('user_id', $theOrder['assigned_user_id'])->count();
        if ($ifWalletExists > 0) {
            // Update wallet
            $myWallet = Wallet::where('user_id', $theOrder['assigned_user_id'])->first();
            $wallet = Wallet::findOrFail($myWallet['id']);
            $wallet->amount = $wallet['amount'] - $fineAmount;
            $wallet->update();
        } elseif ($ifWalletExists == 0) {
            // Create wallet as wallet does not exist
            $wallet = new Wallet();
            $wallet->user_id = $theOrder['assigned_user_id'];
            $wallet->amount = -$fineAmount;
            $wallet->save();
        }

        $transaction = new WalletTransaction();
        $transaction->user_id = $theOrder['assigned_user_id'];
        $transaction->type = 1;
        $transaction->percentage = $request->percentage;
        $transaction->order_id = $request->orderId;
        $transaction->order_number = $theOrder['order_number'];
        $transaction->description = $request->description;
        $transaction->amount = -$fineAmount;
        $transaction->balance = User::find($theOrder['assigned_user_id'])->wallet->amount;
        $transaction->save();

        return response(['status' => 'success'], 200);
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
