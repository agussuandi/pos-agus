@extends('layouts.app')
@section('title', 'POS - Cashier')
@section('content')
    <style>
        input[readonly] {
            background-color: #F6F6F6;
        }
    </style>
    <div class="card">
        <form action="{{ route('sales-order.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="no_faktur" class="col-sm-2 col-form-label">No Faktur</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_faktur" name="no_faktur" readonly value="{{ $uniqueFaktur }}" required />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kode_kasir" class="col-sm-2 col-form-label">Kode Kasir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kode_kasir" name="kode_kasir" autocomplete="off" maxlength="5" oninput="handleCodeKasir(event)" data-url="{{ url('/json/cashier') }}" required />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_kasir" class="col-sm-2 col-form-label">Nama Kasir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly id="nama_kasir" name="nama_kasir" required />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="date_time" class="col-sm-2 col-form-label">Waktu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly id="date_time" name="date_time" required />
                    </div>
                </div>
                <hr />
                <table class="table" id="table-pos">
                    <thead>
                        <tr>
                            <th>Kode Brg</th>
                            <th>Nama Brg</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Jumlah</th>
                            <th>
                                <button type="button" class="btn btn-primary btn-sm" onclick="handleAddRow(event)">+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-pos-row">
                        {{-- javascript --}}
                    </tbody>
                </table>
                <hr />
                <div class="mb-3 row">
                    <label for="total" class="col-sm-2 col-form-label">Total</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="total" name="total" readonly />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jumlah_bayar" class="col-sm-2 col-form-label">Jumlah Bayar</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar" autocomplete="off" maxlength="15" oninput="numberOnly(event); handleJumlahBayar(event);" />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kembali" class="col-sm-2 col-form-label">Kembali</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly id="kembali" name="kembali" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@stop
@section('javascript')
    <script>
        const elDateTime = document.getElementById('date_time')
        const elTablePos = document.getElementById('table-pos')
        const elCashierName = document.getElementById('nama_kasir')
        const elTablePosRow = document.getElementById('table-pos-row')

        document.addEventListener('DOMContentLoaded', event => {
            setInterval(() => {
                elDateTime.value = moment().format('YYYY-MM-DD h:mm:ss')
            }, 1000);
        })

        handleCodeKasir = e => {
            elCashierName.value = ''
            if (e.target.value.length === 5) {
                sendRequest(`GET`, `${e.target.getAttribute('data-url')}/${e.target.value}`, {})
                .then(res => {
                    elCashierName.value = res.name
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }

        handleAddRow = e => {
            let uniqueId = (Math.random() + 1).toString(36).substring(7)

            elTablePosRow.innerHTML += `
                <tr>
                    <td>
                        <input type="text" class="form-control kode-barang" id="kode-barang-${uniqueId}" name="kode_barang[]" data-unique-id="${uniqueId}" autocomplete="off" oninput="handleCodeBarang(event)" maxlength="5" data-url="{{ url('/json/product') }}" />
                    </td>
                    <td>
                        <input type="text" class="form-control" id="nama-barang-${uniqueId}" name="nama_barang[]" data-unique-id="${uniqueId}" readonly />
                    </td>
                    <td>
                        <input type="text" class="form-control" id="harga-barang-${uniqueId}" name="harga_barang[]" data-unique-id="${uniqueId}" readonly />
                    </td>
                    <td>
                        <input type="text" class="form-control qty" id="qty-${uniqueId}" name="qty[]" data-unique-id="${uniqueId}" autocomplete="off" oninput="numberOnly(event); handleQty(event);" maxlength="10" readonly />
                    </td>
                    <td>
                        <input type="text" class="form-control jumlah" id="jumlah-${uniqueId}" name="jumlah[]" data-unique-id="${uniqueId}" autocomplete="off" readonly />
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="handleDeleteRow(event)">-</button>
                    </td>
                </tr>
            `
        }

        handleDeleteRow = e => {
            const td = event.target.parentNode
            const tr = td.parentNode
            tr.parentNode.removeChild(tr)
        }

        handleCodeBarang = e => {
            const uniqueId = e.target.getAttribute('data-unique-id')

            if (e.target.value.length === 5) {
                sendRequest(`GET`, `${e.target.getAttribute('data-url')}/${e.target.value}`, {})
                .then(res => {
                    document.getElementById(`qty-${uniqueId}`).readOnly = false
                    document.getElementById(`nama-barang-${uniqueId}`).value = res.name
                    document.getElementById(`harga-barang-${uniqueId}`).value = currencyFormat(res.price)
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }

        handleQty = e => {
            const uniqueId = e.target.getAttribute('data-unique-id')
            const elHargaBarang = document.getElementById(`harga-barang-${uniqueId}`)
            const elJumlah      = document.getElementById(`jumlah-${uniqueId}`)

            if (e.target.value === null || e.target.value.trim() === '') {
                elJumlah.value = ''
                return
            }

            const numberFormat = elHargaBarang.value.replaceAll(',', '')
            elJumlah.value = currencyFormat(parseInt(numberFormat) * parseInt(e.target.value))

            handleTotal()
        }

        handleTotal = () => {
            const elTotal   = document.getElementById('total')
            const elJumlahs = document.getElementsByClassName('jumlah')
            var total = 0
            for (let index = 0; index < elJumlahs.length; index++) {
                if (elJumlahs[index].value !== null && elJumlahs[index].value.trim() !== '') {
                    total += parseInt(elJumlahs[index].value.replaceAll(',', ''))
                }
            }
            elTotal.value = currencyFormat(total)
        }

        handleJumlahBayar = e => {
            e.target.value = currencyFormat(e.target.value)

            const elTotal = document.getElementById('total')
            const elKembali = document.getElementById('kembali')

            const total = elTotal.value.replaceAll(',', '')
            elKembali.value = currencyFormat(e.target.value.replaceAll(',', '') - total)
        }
    </script>
@endsection
