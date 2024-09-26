@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
    Detail Tagihan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('data-tagihan.index') }}">Daftar Tagihan</a>
                </li>
                <li class="breadcrumb-item active">Bayar</li>
            </ol>
        </nav>

        <!-- Detail Tagihan -->
        <div class="card">
            <div class="card-header">
                Detail Pembayaran
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>ID Tagihan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $tagihan->id_tagihan }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nama Pelanggan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $tagihan->user->name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Bulan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $tagihan->bulan }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Tahun:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $tagihan->tahun }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Meteran Awal:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $tagihan->dataAwal ? $tagihan->dataAwal->awal . ' m³' : 'N/A' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Meteran Akhir:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $tagihan->akhir }} m³
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Tarif:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->tarif) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Total Tagihan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->total_tagihan) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Tunggakan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->tunggakan) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Denda:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->denda) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Lain-Lain:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->lain_lain) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Total Kekurangan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->tunggakan + $tagihan->denda + $tagihan->lain_lain) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Jumlah Yang Harus Dibayarkan:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($tagihan->total_tagihan + $tagihan->tunggakan + $tagihan->denda + $tagihan->lain_lain) }}
                    </div>
                </div>

                <!-- Tombol Pembayaran -->
                <div class="row mt-4">
                    <div class="col-sm-12 text-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#paymentModal">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>

                <!-- Modal untuk memilih jenis pembayaran -->
                <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel">Pilih Jenis Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('store.payment', ['id' => $tagihan->id_tagihan]) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="paymentType" class="form-label">Jenis Pembayaran</label>
                                        <select class="form-select" id="paymentType" name="jenis_pembayaran" required>
                                            <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                            <option value="cash">Cash</option>
                                            <option value="transfer">Transfer</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalPembayaran" class="form-label">Total Pembayaran</label>
                                        <input type="text" class="form-control" id="totalPembayaran"
                                            name="total_pembayaran"
                                            value="{{ formatRupiah($tagihan->total_tagihan + $tagihan->tunggakan + $tagihan->denda + $tagihan->lain_lain) }}"
                                            readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary btn-simpan">Kirim Pembayaran</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        $(function() {
            $('.select2').select2({
                theme: "bootstrap-5"
            });

            $('.btn-simpan').on('click', function(e) {
                e.preventDefault();

                $('#paymentType').ajaxForm({
                    success: function(response) {
                        if (response.success) {
                            // Notifikasi untuk pembayaran cash atau transfer
                            let message = response.jenis_pembayaran === 'cash' ?
                                "Pembayaran berhasil. Silahkan menuju ke kantor terdekat." :
                                "Silahkan selesaikan pembayaran transfer.";

                            swal({
                                title: "Success!",
                                text: message,
                                icon: "success",
                            }).then(function() {
                                // Redirect ke halaman sesuai dengan jenis pembayaran
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            // Notifikasi error
                            var pesan = "";
                            var data_pesan = response
                            .message; // Ganti 'pesan' menjadi 'message'
                            const wrapper = document.createElement('div');

                            if (typeof(data_pesan) === 'object') {
                                jQuery.each(data_pesan, function(key, value) {
                                    pesan += value + '. <br>';
                                    wrapper.innerHTML = pesan;
                                });

                                swal({
                                    title: "Error!",
                                    content: wrapper,
                                    icon: "warning"
                                });
                            } else {
                                // Ubah pesan kesalahan yang ditampilkan
                                swal({
                                    title: "Error!",
                                    text: response.message ||
                                        "Silakan selesaikan tagihan sebelumnya sebelum melakukan pembayaran baru.",
                                    icon: "warning"
                                });
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var err = JSON.parse(jqXHR.responseText);
                        swal("Error!", err.message ||
                            "Terjadi kesalahan saat memproses pembayaran.", "error");
                    }
                }).submit();
            });
        });
    </script>
@endpush
