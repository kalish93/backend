<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return response()->json($events);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = Event::create($validatedData);

        if ($request->hasFile('images')) {
            $images = [];

            foreach ($request->images as $image) {

                // $file = $request->file('file');
                // $fileName = time().'.'.$file->extension();
                // $file->move(public_path('files'), $fileName);
                $fileName = time().'.'.$image->extension();
                $image->move(public_path('files'), $fileName);

                // $images[] = '/files/' . $fileName;
                array_push($images, '/files/' . $fileName);
            }

            $event->update(['images' => $images]);
        }

        return response()->json($event, 201);
    }


    public function show($id)
    {
        return response(Event::find($id));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = Event::find($id);

        $event->update($validatedData);

        if ($request->hasFile('images')) {
            $images = [];

            foreach ($request->file('images') as $image) {
                // $file = $request->file('file');
                // $fileName = time().'.'.$file->extension();
                // $file->move(public_path('files'), $fileName);
                $fileName = time().'.'.$image->extension();
                $image->move(public_path('files'), $fileName);

                $images[] = '/files/' . $fileName;
            }

            $event->update(['images' => $images]);
        }

        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response()->json(null, 204);
    }

}
