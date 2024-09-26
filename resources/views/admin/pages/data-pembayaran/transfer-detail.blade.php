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
                <li class="breadcrumb-item active">Transfer</li>
            </ol>
        </nav>

        <!-- Detail Tagihan -->
        <div class="card">
            <div class="card-header">
                Pembayaran Transfer
            </div>
            <div class="card-body">
                <form action="{{ route('payment.transfer', ['id' => $tagihan->id_tagihan]) }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="bank" class="form-label">Pilih Bank/E-Wallet</label>
                        <select class="form-select" id="bank" name="bank" required>
                            <option value="" disabled selected>Pilih Bank atau E-Wallet</option>
                            @foreach ($bankOptions as $bank)
                                <option value="{{ $bank->bankname_profile_company_banks }}">
                                    {{ $bank->bankname_profile_company_banks }} -
                                    {{ $bank->accountname_profile_company_banks }}
                                    ({{ $bank->accountnumber_profile_company_banks }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="totalPembayaran" class="form-label">Total Pembayaran</label>
                        <input type="text" class="form-control" id="totalPembayaran" name="total_pembayaran"
                            value="{{ formatRupiah($tagihan->total_tagihan + $tagihan->tunggakan + $tagihan->denda + $tagihan->lain_lain) }}"
                            readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
@endpush
