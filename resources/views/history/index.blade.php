@extends('layouts.app')
@section('title', 'POS - Cashier')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Cashier</th>
                        <th>Total Product</th>
                        <th>Total Price</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salesOrders as $key => $salesOrder)
                        <tr>
                            <td>{{ $salesOrders->firstItem() + $key }}</td>
                            <td>{{ $salesOrder->so_date }}</td>
                            <td>{{ $salesOrder->faktur }}</td>
                            <td>{{ "{$salesOrder->cashier_code} - {$salesOrder->cashier_name}" }}</td>
                            <td>{{ $salesOrder->sales_order_products_count }}</td>
                            <td>{{ number_format($salesOrder->total) }}</td>
                            <td>
                                <a href="{{ route('history.show', $salesOrder->id) }}">Show</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('javascript')

@endsection
