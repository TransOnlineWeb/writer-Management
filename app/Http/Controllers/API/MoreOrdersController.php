<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MoreOrdersController extends Controller
{
    public function filesCount($orderId)
    {
        return File::where('order_id', $orderId)->where('isComplete', 0)->count();
    }

    public function getFiles($orderId)
    {
        return File::where('order_id', $orderId)->where('isComplete', 0)->get();
    }

    public function getCompletedFiles($orderId)
    {
        return File::where('order_id', $orderId)->where('isComplete', 1)->get();
    }

    public function downloadFile($id)
    {
        $file = File::where('id', $id)->firstOrFail();
        $pathToFile = storage_path('app/' . $file->path);

        return response()->download($pathToFile);
    }

    public function addFiles(Request $request, $orderId)
    {
        $request->validate([
            'files' => 'required',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $filename = $uploadedFile->store('uploads');
                // echo $filename;
                $file = new File();
                $file->order_id = $orderId;
                $file->path = $filename;
                $orderNo = Order::where('id', $orderId)->value('order_number');
                $file->order_number = $orderNo;
                $file->save();
            }
        }
        return response(['status' => 'success'], 200);
    }

    public function uploadCompleted(Request $request, $orderId)
    {
        $request->validate([
            'files' => 'required',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $filename = $uploadedFile->store('uploads');
                // echo $filename;
                $file = new File();
                $file->order_id = $orderId;
                $file->path = $filename;
                $file->isComplete = 1;
                $orderNo = Order::where('id', $orderId)->value('order_number');
                $file->order_number = $orderNo;
                $file->save();
            }

            $order = Order::findOrFail($orderId);
            $order->status = 3;
            $order->completed_time = Carbon::now();
            $order->update();
            return response(['status' => 'success'], 200);
        }

    }

    public function getWriters(){
        return (object) User::where('role', 'writer')->where('status_id', 1)->get();
    }

    public function getWriter($orderId){
        $user = Order::where('id', $orderId)->value('assigned_user_id');
        return User::where('id', $user)->first();
    }

    public function getCompleted(){
        return Order::latest()->where('status', 5)->paginate(10);
    }

    public function getRevision(){
        return Order::latest()->where('status', 4)->paginate(10);
    }
}
