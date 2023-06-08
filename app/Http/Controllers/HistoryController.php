<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SalesOrder;
use App\Models\SalesOrderProduct;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SalesOrder::withCount('salesOrderProducts')->paginate(10);

        return view('history.index', [
            'salesOrders' => $salesOrders
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $salesOrderProducts = SalesOrderProduct::where('sales_order_id', $id)->get();

        $salesOrder = SalesOrder::find($id);

        return view('history.show', [
            'salesOrder' => $salesOrder
        ]);
    }
}
