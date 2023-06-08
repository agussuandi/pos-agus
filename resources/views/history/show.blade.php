@extends('layouts.app')
@section('title', 'POS - Cashier')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 my-2">
                    No Faktur : {{ $salesOrder->faktur }}
                </div>
                <div class="col-md-6 my-2">
                    Date : {{ $salesOrder->so_date }}
                </div>
                <div class="col-md-6 my-2">
                    Cashier : {{ "{$salesOrder->cashier_code} - {$salesOrder->cashier_name}" }}
                </div>
                <div class="col-md-6 my-2">
                    Total : {{ $salesOrder->total }}
                </div>
                <div class="col-md-6 my-2">
                    Jumlah Bayar : {{ $salesOrder->jumlah_bayar }}
                </div>
                <div class="col-md-6 my-2">
                    Kembali : {{ $salesOrder->kembali }}
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salesOrder->salesOrderProducts as $key => $product)
                        <tr>
                            <td>{{ "{$product->product_code} - {$product->product_name}" }}</td>
                            <td>{{ number_format($product->product_price) }}</td>
                            <td>{{ $product->qty }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('sales-order.index') }}" class="btn btn-warning">Back</a>
        </div>
    </div>
@stop
@section('javascript')

@endsection
