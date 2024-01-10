{{-- create list ticket movie with boostrap --}}
@extends('layout.app')

@section('content')
{{-- make list --}}
<div class="row">
    <div class="col-md-12">
        <div class="p-2">
            <h3 class="text-center">My Ticket</h3>
            <h4>
                Ticket List
            </h4>
            <div id="ticketPaid" class="mb-5">
                <p class="text-center">
                    <b>Belum ada tiket yang dibeli</b>
                </p>
            </div>
            <h4>
                Ticket Unpaid
            </h4>
            <div id="ticketUnpaid" class="mb-5">
                <p class="text-center">
                    <b>Belum ada tiket yang dibeli</b>
                </p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    // get data from database
    $.ajax({
        url: '/api/my-ticket',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (result) {
            fillPaidTicket(result.data.paid);
            fillUnpaidTicket(result.data.unpaid);
        }
    });

    // fill paid ticket

    function fillPaidTicket(data) {
        let html = '';
        data.forEach((item, index) => {
            let jmlTicket = item.nomor_duduk.split(',').length;
            html += `
                <div class="row my-3">
                    <div class="col-12">
                        <div class="rounded overflow-hidden" style="background-color: #c2d1e5">
                            <div class="bg-danger px-3 pt-2 pb-1">
                                <p>
                                    <b>Bioskop Ticket</b>
                                </p>
                            </div>
                            <div class="text-dark px-3 py-2">
                                <div class="row">
                                    <div class="col-8">
                                        <span class="d-block" id="namaFilm">${item.nama_film}</span>
                                        <small class="text-secondary">film</small>
                                        <br>
                                        <span class="d-block" id="tglFilm">${item.jam_tayang}</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="d-block" id="listKursi">${item.nomor_duduk}</span>
                                        <small class="text-secondary">kursi</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <span class="d-block">Harga Tiket</span>
                                    <span class="d-none" id="hargaTiket">${item.harga_tiket}</span>
                                    <span class="d-block"><span id="hargaFormat">Rp. ${formatMoney(item.harga_tiket)}</span> x<span id="jmlTiket">${jmlTicket}</span></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="d-block">Total</span>
                                    <span class="d-block" id="totalBayar">Rp. ${formatMoney(item.harga_tiket * jmlTicket)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
        });
        if (html == '') {
            html = `<p class="text-center">
                        <b>Belum ada tiket yang dibeli</b>
                    </p>`;
        }
        $('#ticketPaid').html(html);
    }

    // fill unpaid ticket

    function fillUnpaidTicket(data) {
        let html = '';
        data.forEach((item, index) => {
            let jmlTicket = item.nomor_duduk.split(',').length;
            html += `
                <div class="row my-3">
                    <div class="col-12">
                        <div class="rounded overflow-hidden" style="background-color: #c2d1e5">
                            <div class="bg-danger px-3 pt-2 pb-1">
                                <p>
                                    <b>Bioskop Ticket</b>
                                </p>
                            </div>
                            <div class="text-dark px-3 py-2">
                                <div class="row">
                                    <div class="col-8">
                                        <span class="d-block" id="namaFilm">${item.nama_film}</span>
                                        <small class="text-secondary">film</small>
                                        <br>
                                        <span class="d-block" id="tglFilm">${item.jam_tayang}</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="d-block" id="listKursi">${item.nomor_duduk}</span>
                                        <small class="text-secondary">kursi</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <span class="d-block">Harga Tiket</span>
                                    <span class="d-none" id="hargaTiket">${item.harga_tiket}</span>
                                    <span class="d-block"><span id="hargaFormat">Rp. ${formatMoney(item.harga_tiket)}</span> x<span id="jmlTiket">${jmlTicket}</span></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="d-block">Total</span>
                                    <span class="d-block" id="totalBayar">Rp. ${formatMoney(item.harga_tiket * jmlTicket)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-danger me-1 paidBtn" data-id="${item.id_order}">
                                Update Status Pembayaran
                            </button>
                            <button class="btn btn-secondary cancelBtn" data-id="${item.id_order}">
                                Batalkan Pembayaran
                            </button>
                        </div>
                    </div>
                </div>`
        });
        if (html == '') {
            html = `<p class="text-center">
                        <b>tidak ada tiket yang belum dibayar</b>
                    </p>`;
        }
        $('#ticketUnpaid').html(html);
    }

    // body on click paidBtn
    $('body').on('click', '.paidBtn', function () {
        let id_order = $(this).data('id');
        updatePayment(2, id_order);
    });

    // body on click cancelBtn
    $('body').on('click', '.cancelBtn', function () {
        let id_order = $(this).data('id');
        updatePayment(3, id_order);
    });

    function formatMoney(number) {
        number = Math.round(number).toString();
        return number.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updatePayment(status, id_order) {
        if (!confirm('Apakah anda yakin?')) {
            return;
        }
        if (status != 2 && status != 3) {
            return;
        }
        $.ajax({
            url: '/api/order-update',
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_order: id_order,
                status_pembayaran: status
            },
            success: function(result) {
                let data = result.data;
                if (data.status_pembayaran == 2) {
                    alert('Pembayaran berhasil');
                } else if (data.status_pembayaran == 3) {
                    alert('Pembayaran dibatalkan');
                }
                location.reload();
            },
            error: function(xhr) {
                alert("terjadi kesalahan");
            }
        });
    }
</script>
@endpush
