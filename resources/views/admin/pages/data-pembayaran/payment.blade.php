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
                <h5>Detail Pembayaran</h5>
            </div>
            <form id="paymentForm" action="{{ route('store.payment', ['id' => $tagihanBulanIni->id_tagihan]) }}"
                method="POST">
                @csrf
                <div class="card-body">
                    <!-- Tunggakan -->
                    <h6 class="mb-3">Tunggakan</h6>
                    @foreach ($allBulan as $bulan)
                        @php
                            // Cari tagihan untuk bulan ini
                            $item = $tagihan->firstWhere('bulan', $bulan->month);
                        @endphp
                        @if (!empty($item) && $item->tunggakan > 0)
                            <div class="form-check">
                                <input class="form-check-input tunggakan-checkbox" type="checkbox" name="tunggakan[]"
                                    value="{{ $item->id_tagihan ?? '' }}" id="tunggakan-{{ $bulan->month }}"
                                    data-amount="{{ $item->tunggakan ?? 0 }}" onchange="updateTotal()" checked>
                                <label class="form-check-label" for="tunggakan-{{ $bulan->month }}">
                                    {{ $bulan->locale('id')->translatedFormat('F Y') }} -
                                    {{ formatRupiah($item->tunggakan) }}
                                </label>
                            </div>
                        @endif
                    @endforeach

                    <!-- Denda -->
                    <h6 class="mt-4">Denda</h6>
                    <div class="form-check">
                        <input class="form-check-input denda-checkbox" type="checkbox" name="denda"
                            value="{{ $denda }}" id="denda" data-amount="{{ $denda }}"
                            onchange="updateTotal()" checked>
                        <label class="form-check-label" for="denda">
                            {{ formatRupiah($denda) }}
                        </label>
                    </div>

                    <!-- Tagihan Bulan Ini -->
                    <h6 class="mt-4">Tagihan Bulan Ini</h6>
                    <div class="form-check">
                        <input class="form-check-input tagihan-checkbox" type="checkbox" name="tagihan_bulan_ini"
                            value="{{ $tagihanBulanIni->total_tagihan }}" id="tagihan-bulan-ini"
                            data-amount="{{ $tagihanBulanIni->total_tagihan }}" onchange="updateTotal()" checked>
                        <label class="form-check-label" for="tagihan-bulan-ini">
                            {{ formatRupiah($tagihanBulanIni->total_tagihan) }}
                        </label>
                    </div>

                    <!-- Total Pembayaran -->
                    <h6 class="mt-4">Total Pembayaran</h6>
                    <p id="totalPembayaran">{{ formatRupiah($totalPembayaran) }}</p>

                    <!-- Jenis Pembayaran -->
                    <h6 class="mt-4">Jenis Pembayaran</h6>
                    <select name="jenis_pembayaran" class="form-select select2" required>
                        <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>

                    <!-- Total Pembayaran -->
                    <input type="hidden" name="total_pembayaran" id="total_pembayaran_input"
                        value="{{ $totalPembayaran }}">

                    <!-- Kirim Pembayaran -->
                    <button type="submit" class="btn btn-primary btn-simpan mt-3">Kirim Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        function updateTotal() {
            let total = 0;

            // Hitung total dari tunggakan yang dicentang
            document.querySelectorAll('.tunggakan-checkbox:checked').forEach(function(checkbox) {
                total += parseInt(checkbox.getAttribute('data-amount'));
            });

            // Tambah denda jika dicentang
            const dendaCheckbox = document.querySelector('.denda-checkbox');
            if (dendaCheckbox.checked) {
                total += parseInt(dendaCheckbox.getAttribute('data-amount'));
            }

            // Tambah tagihan bulan ini jika dicentang
            const tagihanCheckbox = document.querySelector('.tagihan-checkbox');
            if (tagihanCheckbox.checked) {
                total += parseInt(tagihanCheckbox.getAttribute('data-amount'));
            }

            // Tampilkan total dalam format Rupiah
            document.getElementById('totalPembayaran').textContent = formatRupiah(total);
        }

        // Update total saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', updateTotal);
        $(function() {
            $('.select2').select2({
                theme: "bootstrap-5"
            });

            $('.btn-simpan').on('click', function(e) {
                e.preventDefault();

                $('#paymentForm').ajaxForm({
                    success: function(response) {
                        console.log(response); // Tambahkan log untuk respons
                        if (response.success) {
                            let message = response.jenis_pembayaran === 'cash' ?
                                "Pembayaran dengan Cash Berhasil" :
                                "Pembayaran dengan Transfer Berhasil";

                            swal({
                                title: "Success!",
                                text: message,
                                icon: "success",
                            }).then(function() {
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            var pesan = "";
                            var data_pesan = response.message;
                            const wrapper = document.createElement('div');

                            if (typeof(data_pesan) === 'object') {
                                jQuery.each(data_pesan, function(key, value) {
                                    pesan += value + '. <br>';
                                });
                                wrapper.innerHTML = pesan;

                                swal({
                                    title: "Error!",
                                    content: wrapper,
                                    icon: "warning"
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: response.message ||
                                        "Kesalahan saat memproses pembayaran.",
                                    icon: "warning"
                                });
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText); // Log untuk melihat error
                        var err = JSON.parse(jqXHR.responseText);
                        swal("Error!", err.message ||
                            "Terjadi kesalahan saat memproses pembayaran.", "error");
                    }
                }).submit();
            });
        });
    </script>
@endpush
