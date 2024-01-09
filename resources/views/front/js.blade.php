<script>
    $(document).ready(function() {
        drawFilm();
    });

    $('.seat').click(function() {
        if ($(this).hasClass('selected')) {
            return;
        } else if ($(this).hasClass('available')) {
            $(this).toggleClass('occupied');
        }

        let seat = $('.seat');
        let countSeat = 0;
        let seatList = [];
        seat.each(function() {
            if ($(this).hasClass('occupied') && $(this).hasClass('available')) {
                countSeat++;
                seatList.push($(this).attr('id'));
            }
        });

        const hargaTiket = $('#hargaTiket').html();
        let totalBayar = countSeat * hargaTiket;
        totalBayar = totalBayar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        $('#listKursi').html(seatList.join(', '));
        $('#jmlTiket').html(countSeat);
        $('#totalBayar').html("Rp. " + totalBayar);
        $('#payment').attr('disabled', countSeat == 0);
        $('#paymentBtn').attr('disabled', countSeat == 0);
    });

    $('#search').click(function() {
        let keyword = $('#keyword').val();
        $.ajax({
            url: '/api/film',
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                search: keyword
            },
            success: function(result) {
                let data = result.data;
                loopFilm(data);
            }
        });
    });

    $('body').on('click', '#pesanButton', function() {
        let id = $(this).data('id');
        detailFilm(id);
    });

    $('body').on('click', '#payment', function() {
        if (!confirm('Apakah anda yakin ingin melakukan order?')) {
            return;
        }
        makeOrder();
    });

    $('body').on('click', '#paymentBtn', function() {
        if (!confirm('Apakah anda yakin ingin melakukan pembayaran?')) {
            return;
        }
        updatePayment(2);
    });

    $('body').on('click', '#cancelBtn', function() {
        if (!confirm('Apakah anda yakin ingin melakukan pembatalan order?')) {
            return;
        }
        updatePayment(3);
    });

    function drawFilm() {
        $.ajax({
            url: '/api/film',
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(result) {
                let data = result.data;
                let html = '';
                loopFilm(data);
            }
        });
    }

    function loopFilm(data) {
        let html = '';
        data.forEach(function(item) {
            html += `<div class="m-1 shadow rounded" style="width: 200px; background-color: #242340;">
                        <div class="p-1 m-1">
                            <img src="${item.film_image}"
                                class="img-fluid rounded" alt="...">
                        </div>
                        <div class="p-2">
                            <small>
                                ${item.nama_film}
                            </small>
                            <div class="d-flex justify-content-between">
                                <small>
                                    ${item.jam_tayang}
                                </small>
                            </div>
                            <button type="button" class="btn btn-danger d-block btn-sm ms-auto" data-id="${item.id_film}" id="pesanButton">
                                Pesan
                            </button>
                        </div>
                    </div>`;
        });
        $('#filmList').html(html);
    }

    function detailFilm(id) {
        $.ajax({
            url: '/api/film-detail',
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_film: id
            },
            success: function(result) {
                let data = result.data;
                let seatList = data.nomor_duduk;
                let hargaTiket = Math.round(data.harga_tiket).toString();
                hargaTiket = hargaTiket.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                drawSeat(seatList);

                $('#idFilm').val(data.id_film);
                $('#judulFilm').html(data.nama_film + " - "+data.tgl_tayang + " "+data.jam_tayang);
                $('#namaFilm').html(data.nama_film);
                $('#tglFilm').html(data.tgl_tayang);
                $('#jamFilm').html(data.jam_tayang);
                $('#hargaTiket').html(data.harga_tiket);
                $('#hargaFormat').html("Rp. " + hargaTiket);
                $('#listKursi').html('');
                $('#jmlTiket').html('0');
                $('#totalBayar').html("Rp. 0");

                $('#payment').attr('disabled', true);
                $('#paymentBtn').attr('disabled', true);
                
                $('#pesanModal').modal('show');
            }
        });
    }

    function drawSeat(seatList) {
        let seat = $('.seat');
        seat.each(function() {
            let id = $(this).attr('id');
            if (seatList.includes(id)) {
                $(this).addClass('bg-danger');
                $(this).removeClass('available');
            } else {
                $(this).addClass('available');
                $(this).removeClass('bg-danger');
            }
            $(this).removeClass('selected');
            if ($(this).hasClass('occupied')) {
                $(this).removeClass('occupied');
            }
        });
    }

    function makeOrder() {
        let seat = $('.seat');
        let seatList = [];
        seat.each(function() {
            if ($(this).hasClass('occupied') && $(this).hasClass('available')) {
                seatList.push($(this).attr('id'));
            }
        });
        $.ajax({
            url: '/api/order',
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_film: $('#idFilm').val(),
                id_status_pembayaran: 1,
                nomor_duduk: seatList.join(', ')
            },
            success: function(result) {
                let data = result.data;
                $('#idOrder').html(data.order_id);
                $('#paymentBtn').attr('disabled', false);
                $('#paymentBtn').data('id', data.order_id);
                $('#paymentModal').modal('show');
                $('#pesanModal').modal('hide');
            }
        });
    }

    function updatePayment(status) {
        if (status != 2 && status != 3) {
            return;
        }
        $.ajax({
            url: '/api/order-update',
            type: 'post',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_order: $('#paymentBtn').data('id'),
                status_pembayaran: status
            },
            success: function(result) {
                let data = result.data;
                $('#paymentModal').modal('hide');
                $('#pesanModal').modal('hide');
                if (status == 2) {
                    alert('Pembayaran berhasil');
                } else {
                    alert('Pembatalan berhasil');
                }
            }
        });
    }
</script>
