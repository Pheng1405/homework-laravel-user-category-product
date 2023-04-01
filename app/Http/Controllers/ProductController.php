<?php

namespace App\Http\Controllers;

use App\Models\Product;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $product = Product::all();
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category')
            ->get();
        return $products;
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
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            // 'images' => 'required' 
        ]);

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            // 'images' => Cloudinary::upload($request->file('images')->getRealPath())->getSecurePath(),
        ]);

        return $product;
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
        $product = Product::find($id);
        
        if(!$product){
            return response([
                'status' => 'failed',
                'message' => 'Could not find product id = '.$id
            ],404);
        }

        if(!is_null( $request->title)){
            $product->title = $request->title;
        }
        if(!is_null( $request->description)){
            $product->description = $request->description;
        }
        if(!is_null($request->price)){
            $product->price = $request->price;
        }
        if(!is_null($request->category_id)){
            $product->category_id = $request->category_id;
        }
        // if(!is_null($request->images)){
        //     $product->images = $request->images;
        // }

        try{
            $product->save();
        }
        catch(Throwable $th){
            return response([
                'status'  => "failed",
                "message" => $th->getMessage()   
            ]);
        }
        



        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::destroy($id);
        
        if(!$product){
            return response([
                'status' => 'failed',
                'message' => 'Could not find product id = '.$id
            ],404);
        }

        return response([
            'status' => "success",
            "message" => "product id = $id has been deleted" 
        ]);
    }
}
