<?php

namespace App\Http\Controllers\API;

use App\Events\ChatEvent;
use App\Events\NewMessage;
use App\Messenger;
use App\Notifications\RepliedToThread;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class MessangerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function getMessagesFor($orderId){
        $messages = Messenger::where('Oder_id',$orderId)->get();
        return response()->json($messages);
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
    public function send(Request $request)
    {
        $message = Messenger::create([
            'from'=> auth()->user()->id,
            'to'=>$request->contact_id,
            'text'=>$request->text,
            'Oder_Id'=>$request->OrderId,
        ]);
        broadcast(new ChatEvent($message));
        return response()->json($message);
    }

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
