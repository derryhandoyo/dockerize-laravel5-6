<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductImage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Image;
use Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);

        return view('products.index', compact('products'))
            ->with(
                'i', (request()->input('page', 1) - 1) * 5
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]
        );

        // Product::create($request->all());

        // return redirect()->route('products.index')
        //     ->with(
        //         'success',
        //         'Product created successfully'
        //     );
        // dd($request);

        $image_file = $request->file('image')->getRealPath();
        $image = Image::make($image_file);
        $b64 = base64_encode($image->encode()->encoded);
        // dd($image_file);


        // $file = $request->file('image');
        // $image = $file->openFile()->fread($file->getSize());

        // $image_file = $request->file('image')->getRealPath();
        // $logo = file_get_contents($image_file);         
        // $image = base64_encode($logo);

        $product = new Product(
            [
                'name' => $request->name,
                'detail' => $request->detail,
                'price' => $request->price,
                'image' => $b64
            ]
            );
        if ($product->save()) {
            if ($request->hasfile('detailimages')) {
                foreach ($request->detailimages as $detailimage) {                    
                    $image_file = $detailimage->getRealPath();                    
                    $image = Image::make($image_file);
                    $b64 = base64_encode($image->encode()->encoded);

                    $productimage = new ProductImage(
                        [
                            'product_id' => $product->id,
                            'image' => $b64
                        ]
                    );
                    $productimage->save();
                }
            }
        }

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(
            [
                'name' => 'required',
                'price' => 'required'
            ]
        );

        // dd($request);
        // $product->update($request->all());


        if ($request->hasfile('image')) {
            $image_file = $request->file('image')->getRealPath();
            $image = Image::make($image_file);
            $b64 = base64_encode($image->encode()->encoded);
            $product->update(
                [
                    'name' => $request->name,
                    'detail' => $request->detail,
                    'price' => $request->price,
                    'image' => $b64
                ]
            );
        } else {
            $product->update(
                [
                    'name' => $request->name,
                    'detail' => $request->detail,
                    'price' => $request->price,
                ]
            );
        }

        return redirect()->route('products.index')
        ->with(
                'success',
                'Product updated successfully'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
        ->with(
                'success',
                'Product deleted successfully'
            );
    }

    function fetch_image($id)
    {
        $product = Product::findOrFail($id);

        $image_file = Image::make($product->image);

        $response = Response::make($image_file->encode('jpeg'));

        $response->header('Content-Type', 'image/jpeg');

        return $response;
    }
}