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

        <div class="card">
            <div class="card-header">
                Informasi Pembayaran
            </div>
            <div class="card-body">
                <p><strong>ID Tagihan:</strong> {{ $tagihan->id_tagihan }}</p>
                <p><strong>Nama Pemohon:</strong> {{ $tagihan->user->name }}</p>
                <p><strong>Total Tagihan:</strong> {{ formatRupiah($tagihan->total_tagihan) }}</p>
                <p><strong>Denda:</strong> {{ formatRupiah($tagihan->denda) }}</p>
                <p><strong>Tunggakan:</strong> {{ formatRupiah($tagihan->tunggakan) }}</p>
                <p><strong>Lain-lain:</strong> {{ formatRupiah($tagihan->lain_lain) }}</p>
                <p><strong>Jenis Pembayaran:</strong> Transfer</p>
                <p><strong>Bank: </strong>{{ $bank->bankname_profile_company_banks }}</p>
                <p><strong>Nama Rekening: </strong>{{ $bank->accountname_profile_company_banks }}</p>
                <p><strong>Nomor Rekening: </strong>{{ $bank->accountnumber_profile_company_banks }}</p>
                <p><strong>Total Pembayaran:</strong></strong> {{ formatRupiah($totalPembayaran) }}</p>

                <form action="{{ route('upload.bukti.transfer', ['id' => $tagihan->id_tagihan]) }}" method="POST"
                    enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="mb-3">
                        <label for="bukti_transfer" class="form-label">Upload Bukti Transfer</label>
                        <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Bukti Transfer</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
