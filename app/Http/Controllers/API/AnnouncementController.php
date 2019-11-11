<?php

namespace App\Http\Controllers\API;

use App\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
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
        return Announcement::where('status', 'Complete')->latest()->paginate(10);
    }
    public function announce()
    {
        return Announcement::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'message' => 'required',
            'status' => 'required'
        ]);

        return Announcement::create([
            'title' => $request['title'],
            'message' => $request['message'],
            'status' => $request['status'],
        ]);
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
        $message = Announcement::findorFail($id);

        $this->validate($request, [
            'title' => 'required|string',
            'message' => 'required',
            'status' => 'required'
        ]);

        $message->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Announcement::findorFail($id);

        $message->delete();
    }
}
