<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalAnnouncement;

class InternalAnnouncementController extends Controller
{
    //
    public function create(Request $request){
        $data = $request->validate([
            'description' => 'required|string',
            'title'=> 'required|string',
            'file' => 'nullable'
         ]);

         if($request->file('file')){
            $file = $request->file('file');
            $fileName = time().'.'.$file->extension();
            $file->move(public_path('files'), $fileName);
            $announcement = InternalAnnouncement::create([
                'description' => $data['description'],
                'title' => $data['title'],
                'file' => '/files/' . $fileName
             ]);
         }else{
            $announcement = InternalAnnouncement::create([
                'description' => $data['description'],
                'title' => $data['title']
             ]);
         }

         return response($announcement);

    }

    public function getAnnouncemets(){
        return InternalAnnouncement::all();
    }

    public function getAnnoumcement($id){
        return InternalAnnouncement::find($id);
    }

    public function update(Request $request, $id){

    }

    public function destroy($id){
        $announcement = InternalAnnouncement::find($id);
        $announcement->delete();
    }

}
