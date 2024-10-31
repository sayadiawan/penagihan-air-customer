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
                    <!-- Tabel Pembayaran -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Tunggakan -->
                            @php
                                $hasTunggakan = $tagihan->firstWhere('tunggakan', '>', 0); // Cek apakah ada tunggakan
                            @endphp

                            @if (!empty($hasTunggakan))
                                @foreach ($allBulan as $bulan)
                                    @php
                                        $item = $tagihan->firstWhere('bulan', $bulan->month);
                                    @endphp
                                    @if (!empty($item) && $item->tunggakan > 0)
                                        <tr>
                                            <td>{{ $bulan->locale('id')->translatedFormat('F Y') }} - Tunggakan</td>
                                            <td>{{ formatRupiah($item->tunggakan) }}</td>
                                            <td>
                                                <input class="form-check-input tunggakan-checkbox" type="checkbox"
                                                    name="tunggakan[]" value="{{ $item->id_tagihan }}"
                                                    data-amount="{{ $item->tunggakan }}" onchange="updateTotal()" checked>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif

                            <!-- Denda -->
                            <tr>
                                <td>Denda</td>
                                <td>{{ formatRupiah($denda) }}</td>
                                <td>
                                    <input class="form-check-input denda-checkbox" type="checkbox" name="denda"
                                        value="{{ $denda }}" data-amount="{{ $denda }}"
                                        onchange="updateTotal()" checked>
                                </td>
                            </tr>

                            <!-- Tagihan Bulan Ini -->
                            <tr>
                                <td>Tagihan Bulan Ini</td>
                                <td>{{ formatRupiah($tagihanBulanIni->total_tagihan) }}</td>
                                <td>
                                    <input class="form-check-input tagihan-checkbox" type="checkbox"
                                        name="tagihan_bulan_ini" value="{{ $tagihanBulanIni->total_tagihan }}"
                                        data-amount="{{ $tagihanBulanIni->total_tagihan }}" onchange="updateTotal()"
                                        checked>
                                </td>
                            </tr>

                            <!-- Total Pembayaran -->
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total Pembayaran:</strong></td>
                                <td><strong id="totalPembayaran">{{ formatRupiah($totalPembayaran) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Nominal Deposit -->
                    <h6 class="mt-4">Masukkan Nominal Deposit</h6>
                    <input type="number" name="nominal_deposit" class="form-control" required min="1"
                        placeholder="Masukkan nominal deposit">

                    <!-- Jenis Pembayaran -->
                    <h6 class="mt-4">Jenis Pembayaran</h6>
                    <select name="jenis_pembayaran" class="form-select select2" required>
                        <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>

                    <!-- Total Pembayaran (hidden input) -->
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
                            const wrapper = document.createElement('div');
                            let pesan = Array.isArray(response.message) ? response.message.join(
                                '. <br>') : response.message;
                            wrapper.innerHTML = pesan;

                            swal({
                                title: "Error!",
                                content: wrapper,
                                icon: "warning"
                            });
                        }
                    },
                    error: function(jqXHR) {
                        const err = JSON.parse(jqXHR.responseText);
                        swal("Error!", err.message ||
                            "Terjadi kesalahan saat memproses pembayaran.", "error");
                    }
                }).submit();
            });
        });
    </script>
@endpush
