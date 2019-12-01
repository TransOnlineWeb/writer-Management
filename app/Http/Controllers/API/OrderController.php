<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Mail\NewOrder;
use App\Order;
use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
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
        if (auth()->user()->role == "admin") {
            return Order::latest()->paginate(10);
        } elseif (auth()->user()->role == "writer") {
            return Order::latest()->where('status', 0)->paginate(10);
        }elseif (auth()->user()->role == "editor"){
            return Order::latest()->where('status', 3)->paginate(10);
        }
    }
    public function user($orderId)
    {
        return Order::where('id', $orderId)->value('assigned_user_id');
    }
    public function admin()
    {
        return User::where('role','admin')->value('id');
    }

    public function getMyOrders(){
        return Order::latest()->where('assigned_user_id', auth()->user()->id)->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'discipline' => 'required',
            'order_number' => 'required|unique:orders',
            'title' => 'required',
            'pages' => 'required',
            'deadline' => 'required',
            'spacing' => 'required',
            'paper_format' => 'required',
            'description' => 'required',
            'urgent' => 'required',
            'viewers' => 'required',
        ]);

        //Not Urgent
        if ($request->urgent == 0) {
            $order = new Order();
            if ($request->writer) {
                $order->assigned_user_id = $request->writer;
                $order->status = 1;
                $level_id = User::where('id', $request->writer)->value('level_id');
                $amount = Category::where('id', $level_id)->value('amount');
                $order->amount = $amount;
                $order->total_amount = $amount * $request->pages;

                $email = User::where('id',$request->writer)->value('email');
                $data = array(
                    'title' => $request->title,
                    'pages' => $request->pages,
                    'subject'=>$request->discipline,
                    'deadline' => $request->deadline,
                );
                Mail::to($email)->send(new NewOrder($data));
            } else {
                $order->status = 0;
            }
            $order->order_number = $request->order_number;
            $order->title = $request->title;
            $order->description = $request->description;
            $order->deadline = $request->deadline;
            $order->pages = $request->pages;
            $viewers = $request->viewers;
            $order->viewers = implode(',', $viewers);
            $order->academic_level = $request->level;
            $order->discipline = $request->discipline;
            $order->paper_format = $request->paper_format;
            $order->spacing = $request->spacing;
            $order->save();
            $order_id = $order->id;
            $email = User::where('role','writer')->get()->toArray();
            $data = array(
                'title' => $request->title,
                'pages' => $request->pages,
                'subject'=>$request->discipline,
                'deadline' => $request->deadline,
            );
            Mail::to($email)->send(new NewOrder($data));

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $uploadedFile) {
                    $filename = $uploadedFile->store('uploads');
                    // echo $filename;
                    $file = new File();
                    $file->order_id = $order_id;
                    $file->path = $filename;
                    $file->order_number = $request->order_number;
                    $file->save();
                }
            }
            return response(['status' => 'success'], 200);

            // When Urgent
        } elseif ($request->urgent == 1) {
            $order = new Order();
            if ($request->writer) {
                $order->assigned_user_id = $request->writer;
                $order->status = 1;
            } else {
                $order->status = 0;
            }
            $order->order_number = $request->order_number;
            $order->title = $request->title;
            $order->description = $request->description;
            $order->deadline = $request->deadline;
            $order->pages = $request->pages;
            $order->amount = $request->amount;
            $order->total_amount = $request->amount * $request->pages;
            $viewers = $request->viewers;
            $order->viewers = implode(',', $viewers);
            $order->academic_level = $request->level;
            $order->discipline = $request->discipline;
            $order->paper_format = $request->paper_format;
            $order->spacing = $request->spacing;
            $order->urgency = $request->urgent;
            $order->save();
            $order_id = $order->id;

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $uploadedFile) {
                    $filename = $uploadedFile->store('uploads');
                    // echo $filename;
                    $file = new File();
                    $file->order_id = $order_id;
                    $file->path = $filename;
                    $file->order_number = $request->order_number;
                    $file->save();
                }
            }

            return response(['status' => 'success'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::where('id', $id)->first();
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
