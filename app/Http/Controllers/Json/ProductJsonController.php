<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductJsonController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::code($id)->first();

        return response()->json($product);
    }
}
