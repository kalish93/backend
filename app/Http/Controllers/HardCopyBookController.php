<?php

namespace App\Http\Controllers;

use App\Models\HardCopyBook;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class HardCopyBookController extends Controller
{
    //
    public function importFromExcel(Request $request){
        $books = Excel::toArray([], $request->file('file'))[0];
        $books = array_slice($books,1);


        foreach($books as $book){
            HardCopyBook::create([
                'title' => $book[0],
                'author' => $book[1],
                'edition' => $book[2],
                'subject' => $book[3]
            ]);
        }

        return response(['message'=> 'books registered successfully']);
    }

    public function getBooks(){
        return HardCopyBook::all();
    }

    public function downloadTemplate()
    {
        $headings = [
            'Title',
            'Author',
            'Edition',
            'Subject'
        ];

        $data = [
            // Example row (optional)
            ['Example Title', 'Example Author', '1st', 'Example Subject']
        ];

        return Excel::download(new class($data, $headings) implements FromArray, WithHeadings {
            protected $data;
            protected $headings;

            public function __construct(array $data, array $headings)
            {
                $this->data = $data;
                $this->headings = $headings;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headings;
            }
        }, 'hardcopy_books_template.xlsx');
    }
}
