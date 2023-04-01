<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Category::all();

            return response([
                'data' => $data
            ]);
        }
        catch(Throwable $th){
            return response([
                'status' => 'failed',
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required'
        ]);

        try{
            Category::create(['name' => $request->name]);
            return response([
                'status' => 'Success',
                'data' => $request->name
            ]);

        }
        catch(Throwable $th){
            return response([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 404);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //

        $category = Category::find($id);
        if(!$category){
            return response([
                'status' => 'failed',
                'message' => 'could not find category'
            ]);
        }

        $category->name =  $request->name;

        $category->save();

        return response(
            [
                'status' => 'success',
                'data'   => $request->name
            ]
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::destroy($id);
        if(!$category){
            return response([
                'status' => 'failed',
                'message' => 'could not find category'
            ]);
        }


        return response(
            [
                'status' => 'success'
            ]
        );
    }
}
