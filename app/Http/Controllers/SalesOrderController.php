<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\SalesOrder;
use App\Models\SalesOrderProduct;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cashier.index', [
            'uniqueFaktur' => $this->uniqueFaktur()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            DB::transaction(function() use($request) {
                $salesOrder = SalesOrder::create([
                    'so_date'       => today(),
                    'faktur'        => $request->input('no_faktur'),
                    'cashier_code'  => $request->input('kode_kasir'),
                    'cashier_name'  => $request->input('nama_kasir'),
                    'total'         => $this->replaceComma($request->input('total')),
                    'jumlah_bayar'  => $this->replaceComma($request->input('jumlah_bayar')),
                    'kembali'       => $this->replaceComma($request->input('kembali'))
                ]);

                foreach ($request->input('kode_barang') as $key => $barang)
                {
                    $salesOrderProduct = SalesOrderProduct::create([
                        'sales_order_id' => $salesOrder->id,
                        'product_code'   => $barang,
                        'product_name'   => $request->input('nama_barang')[$key],
                        'product_price'  => $this->replaceComma($request->input('harga_barang')[$key]),
                        'qty'            => $request->input('qty')[$key]
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Successfully create Sales Order');
        }
        catch (\Throwable $th)
        {
            abort(500);
        }
    }

    /**
     * Generate unique faktor from sales_order.
     */
    protected function uniqueFaktur()
    {
        $lastSo = SalesOrder::selectRaw('MAX(SUBSTRING(faktur, 12)) as no_faktur')
            ->whereMonth('so_date', date('m'))
        ->first();

        if($lastSo->no_faktur) $increment = (int)$lastSo->no_faktur + 1;
        else $increment = 1;

        return 'PSI-'.date('Ym').'-'.str_pad($increment, 4, 0, STR_PAD_LEFT);
    }

    /**
     * Replace commas on string.
     */
    protected function replaceComma(string $string)
    {
        return str_replace(',', '', $string);
    }
}
