<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Illuminate\Http\Request;

class MoreOrdersController extends Controller
{
    public function filesCount($orderId)
    {
        return File::where('order_id', $orderId)->count();
    }

    public function getFiles($orderId)
    {
        return File::where('order_id', $orderId)->get();
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

    public function getWriters(){
        return (object) User::where('role', 'writer')->where('status_id', 1)->get();
    }

    public function getWriter($orderId){
        $user = Order::where('id', $orderId)->value('assigned_user_id');
        return User::where('id', $user)->first();
    }
}
