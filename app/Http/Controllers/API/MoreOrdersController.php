<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Http\Controllers\Controller;
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

    public function downloadFile($id){
        $file = File::where('id', $id)->firstOrFail();
        $pathToFile = storage_path('app/' . $file->path);

        return response()->download($pathToFile);
    }

    public function addFiles(Request $request){
        $request->validate([
            'files' => 'required',
        ]);
    }
}
