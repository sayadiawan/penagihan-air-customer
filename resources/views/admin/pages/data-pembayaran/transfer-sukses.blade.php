@extends('admin.layouts.app')

@section('title')
    Transaksi Sukses
@endsection

@section('content')
    <style>
        .loading-animation {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 200px;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('data-tagihan.index') }}">Daftar Tagihan</a>
                </li>
                <li class="breadcrumb-item active">Transaksi Sukses</li>
            </ol>
        </nav>

        <div class="card text-center">
            <div class="card-header">
                Pembayaran Berhasil!
            </div>
            <div class="card-body">
                <div class="loading-animation" id="loadingAnimation">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Sedang memproses...</p>
                </div>

                <div class="success-message" id="successMessage" style="display: none;">
                    <h5 class="card-title mt-4">
                        <i class="bi bi-check-circle-fill" style="color: green; font-size: 50px;"></i>
                    </h5>
                    <h5 class="card-title mt-4">Transaksi berhasil!</h5>
                    <p>Terima kasih, bukti transfer Anda telah berhasil diunggah.</p>
                    <p>Anda dapat melihat detail transaksi Anda di halaman <a
                            href="{{ route('data-tagihan.index') }}">tagihan</a>.</p>
                </div>
            </div>
            <div class="card-footer text-muted">
                &copy; {{ date('Y') }} Nama Perusahaan Anda
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loadingAnimation = document.getElementById('loadingAnimation');
                const successMessage = document.getElementById('successMessage');

                if (loadingAnimation) {
                    loadingAnimation.style.display = 'none';
                }
                if (successMessage) {
                    successMessage.style.display = 'block';
                }
            }, 3000); // Durasi loading dalam milidetik
        });
    </script>
@endpush
