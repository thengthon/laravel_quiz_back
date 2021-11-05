<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "string|min:3|max:10",
            "body" => "string|min:3|max:50"
        ]);
        $book = new Book();
        $book->author_id = $request->author_id;
        $book->title = $request->title;
        $book->body = $request->body;

        $book->save();
        return response()->json(["Message" => "Book Created", "Book" => $book], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookResource(Book::findOrFail($id));
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
        $request->validate([
            "title" => "string|min:3|max:10",
            "body" => "string|min:3|max:50"
        ]);
        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->body = $request->body;

        $book->save();
        return response()->json(["Message" => "Book Updated", "Book" => $book], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDelete = Book::destroy($id);
        if($isDelete){
            return response()->json(["Message" => "Deleted"], 200);
        }
        return response()->json(["Message" => "BOOK ID NOT FOUND"], 404);
    }
}