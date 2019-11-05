<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Order;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::latest()->paginate(10);
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
            'order_number' => 'required',
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
            $order->order_number = $request->order_number;
            $order->title = $request->title;
            $order->description = $request->description;
            $order->deadline = $request->deadline;
            $order->pages = $request->pages;
            $order->status = 0;
            $viewers = $request->viewers;
            $order->viewers = implode(',', $viewers);
            $order->academic_level = $request->level;
            $order->discipline = $request->discipline;
            $order->paper_format = $request->paper_format;
            $order->spacing = $request->spacing;
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

            // When Urgent
        } elseif ($request->urgent == 1) {
            $order = new Order();
            $order->order_number = $request->order_number;
            $order->title = $request->title;
            $order->description = $request->description;
            $order->deadline = $request->deadline;
            $order->pages = $request->pages;
            $order->status = 0;
            $order->amount = $request->amount;
            $order->total_amount = $request->amount * $request->pages;
            $viewers = $request->viewers;
            $order->viewers = implode(',', $viewers);
            $order->academic_level = $request->level;
            $order->discipline = $request->discipline;
            $order->paper_format = $request->paper_format;
            $order->spacing = $request->spacing;
            $order->urgency = $request->urgency;
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
