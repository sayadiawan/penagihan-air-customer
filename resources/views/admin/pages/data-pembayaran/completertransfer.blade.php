@extends('admin.layouts.app')

@section('title')
    Detail Pembayaran Transfer
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
                <li class="breadcrumb-item active">Detail Pembayaran Transfer</li>
            </ol>
        </nav>

        <!-- Detail Pembayaran Transfer -->
        <div class="card">
            <div class="card-header">
                Detail Pembayaran Transfer
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>ID Pembayaran:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $payment->id }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Jenis Pembayaran:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $payment->jenis_pembayaran }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Total Pembayaran:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ formatRupiah($payment->total_pembayaran) }}
                    </div>
                </div>
                <!-- Tambahkan detail lainnya sesuai kebutuhan -->
            </div>
        </div>
    </div>
@endsection
