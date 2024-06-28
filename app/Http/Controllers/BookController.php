<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    //

    public function upload(Request $request){
        // $this->authorize("create_update_delete_books");

        $file = $request->file('file');
        $fileName = time().'.'.$file->extension();
        $file->move(public_path('files'), $fileName);

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'file' => '/files/' . $fileName,
            'course_title' => $request->course_title,
            'program'=>$request->program,
            'user_id'=> Auth::user()->id
        ]);

        return response($book);
    }


    public function index(){
        return Book::all();
    }


    public function show($id){
        $book = Book::find($id);
        return response($book);
    }
}
