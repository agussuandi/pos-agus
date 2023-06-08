<?php

namespace App\Http\Controllers\Json;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Cashier;

class CashierJsonController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cashier = Cashier::code($id)->first();

        return response()->json($cashier);
    }
}
