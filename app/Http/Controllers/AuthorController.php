<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AuthorResource::collection(Author::with(['book'])->get()->take(3));
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
            "name" => "string|min:3|max:10",
            "age" => "integer|min:1|max:10",
            "province" => "nullable"
        ]);
        $auth = new Author();
        $auth->name = $request->name;
        $auth->age = $request->age;
        $auth->province = $request->province;

        $auth->save();
        return response()->json(["Message" => "Author Created", "Author" => $auth], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AuthorResource(Author::findOrFail($id));
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
            "name" => "string|min:3|max:10",
            "age" => "integer|min:1|max:10",
            "province" => "nullable"
        ]);
        $auth = Author::findOrFail($id);
        $auth->name = $request->name;
        $auth->age = $request->age;
        $auth->province = $request->province;

        $auth->save();
        return response()->json(["Message" => "Author Updated", "Author" => $auth], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDelete = Author::destroy($id);
        if($isDelete){
            return response()->json(["Message" => "Deleted"], 200);
        }
        return response()->json(["Message" => "AUTHOR ID NOT FOUND"], 404);
    }
}