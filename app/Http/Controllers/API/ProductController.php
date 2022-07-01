<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        #request input for id
        $id = $request->input('id');
        /* Getting the limit from the request. */
        $limit = $request->input('limit');
        #input name
        $name = $request->input('name');
        #input description
        $description = $request->input('description');
        #input tags
        $tags = $request->input('tags');
        #input categories
        $categories = $request->input('categories');

        #input for price_from
        $price_from = $request->input('price_from');
        #input for price_to
        $price_to = $request->input('price_to');

        /* Checking if the id is present in the request. If it is, it will return the product with the
        category and images. */
        if ($id) {
            $product = Product::with(['category', 'images'])->find($id);

            if ($product) {
                return ResponseFormatter::success($product, 'Product found');
            } else {
                return ResponseFormatter::error(null, 'Product not found', 404);
            }
        }

        #get data from product and images
        $product = Product::with(['category', 'images']);

        #Filter by name
        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        #Filter by description
        if ($description) {
            $product->where('descriptions', 'like', '%' . $description . '%');
        }

        #Filter by tags
        if ($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }

        #Filter by Price From
        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        #Filter by Price To
        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        #Filter by categories
        if ($categories) {
            $product->where('categories_id', $categories);
        }

        #Return the data
        return ResponseFormatter::success($product->paginate($limit), 'Products found');
    }
}
