<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductImage;
use Response;

class ProductImageController extends Controller
{
    public function destroy($id)
    {
        $productImage = ProductImage::find($id);
        $productImage->delete();
              
        return Response::json($productImage);
    }
}
