<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    //
    public function index(){
        return Announcement::all();
    }

    public function store(Request $request){
        // $this->authorize("create_update_delete_announcements");
        $data = $request->validate([
            'title' => 'required|string',
            'description'=> 'required|string'
        ]);

        $announcement = Announcement::create($data);
        return response($announcement);
    }

    public function show($id){
        return Announcement::find($id);
    }

    public function destroy($id){
        // $this->authorize("create_update_delete_announcements");

        $announcement = Announcement::find($id);
        return $announcement->delete();
    }

    public function update(Request $request,$id){
        // $this->authorize("create_update_delete_announcements");

        $announcement = Announcement::find($id);
        $announcement->update($request);
        return $announcement;
    }
}
