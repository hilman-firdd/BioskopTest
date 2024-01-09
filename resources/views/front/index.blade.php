@extends('layout.app')

@section('content')
    @php
        $seatRow = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
    @endphp
    <h2 class="text-center text-white">List Film</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Film" aria-label="Recipient's username"
                        aria-describedby="search" id="keyword">
                    <button class="btn btn-danger" type="button" id="search">Cari</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-center" id="filmList">
            </div>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
        <div class="modal-dialog slide-modal modal-xl">
            <div class="modal-content" style="background-color: #242333">
                <div class="modal-body">
                    <h4 class="fw-bold" id="judulFilm"></h4>
                    <div class="row mt-4 mb-2">
                        <div class="col-lg-6 col-12">
                            <div class="p-2">
                                <div class="card-body">
                                    <h4 class="text-white text-center">Pilih Kursi</h4>
                                    <div class="d-flex justify-content-center">
                                        <div class="justify-content-center">
                                            <div class="screen"></div>
                                            @foreach ($seatRow as $row)
                                                <div class="row">
                                                    @for ($i = 1; $i <= 8; $i++)
                                                        <div class="seat" id="{{ $row . $i }}">
                                                        </div>
                                                    @endfor
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 px-lg-5 px-2">
                            <hr class="d-lg-none d-block">
                            <p>
                                Pilih kursi yang tersedia, lalu klik tombol pesan untuk melanjutkan ke pembayaran.
                                <hr>
                            </p>
                            <div class="d-flex justify-content-start mt-3">
                                <button class="btn btn-danger me-1" id="payment" disabled>Pesan</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: #242333">
                <div class="modal-body">
                    <div class="row mt-4 mb-2">
                        <div class="col-12 px-lg-5 px-2">
                            <h5>
                                <b>Detail Pembayaran</b>
                            </h5>
                            <span class="mb-2">
                                invoice order no : #<span id="idOrder"></span>
                            </span>
                            <div class="rounded overflow-hidden" style="background-color: #c2d1e5">
                                <div class="bg-danger px-3 pt-2 pb-1">
                                    <p>
                                        <b>Bioskop Ticket</b>
                                    </p>
                                </div>
                                <div class="text-dark px-3 py-2">
                                    <div class="row">
                                        <div class="col-8">
                                            <span class="d-none" id="idFilm"></span>
                                            <span class="d-block" id="namaFilm"></span>
                                            <small class="text-secondary">film</small>
                                            <br>
                                            <span class="d-block" id="tglFilm"></span>
                                            <span class="d-block" id="jamFilm">pukul 13:00</span>
                                        </div>
                                        <div class="col-4">
                                            <span class="d-block" id="listKursi"></span>
                                            <small class="text-secondary">kursi</small>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <span class="d-block">Harga Tiket</span>
                                        <span class="d-none" id="hargaTiket">0</span>
                                        <span class="d-block"><span id="hargaFormat">0</span> x<span id="jmlTiket">0</span></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="d-block">Total</span>
                                        <span class="d-block" id="totalBayar">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mt-3">
                                <button class="btn btn-danger me-1" id="paymentBtn" disabled>Update Status Pembayaran</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close" id="cancelBtn">Batalkan Pembayaran</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('front.js')
@endpush
