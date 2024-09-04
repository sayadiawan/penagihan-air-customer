@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
    Home
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Hai {{ Auth::user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    Anda sedang memiliki <strong>4 resi</strong> aktif, yuk cek sekarang.
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">Lihat Resi</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('admin-assets/assets/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Jumlah Artikel</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">17</h4>
                                </div>


                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class="fas fa-newspaper"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Jumlah Agen</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">10</h4>
                                </div>


                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-info rounded p-2">
                                    <i class="fas fa-users"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">Jumlah Diskon</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">3</h4>
                                </div>


                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded p-2">
                                    <i class="fas fa-tag"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @auth
            @if (auth()->user()->role->code_roles === 'ADM' || auth()->user()->role->code_roles === 'SAS')
                <div class="row" id="dashboard-data">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Tagihan Belum Terbayar</h5>
                                <p class="card-text" id="data-total-belum-terbayar">{{ $totalBelumTerbayar }}</p>
                                <p class="card-text">Jumlah Pelanggan : {{ $jumlahPelangganBelumTerbayar }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Tagihan Sudah Terbayar</h5>
                                <p class="card-text" id="data-total-sudah-terbayar">{{ $totalSudahTerbayar }}</p>
                                <p class="card-text">Jumlah Pelanggan : {{ $jumlahPelangganSudahTerbayar }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
        <div class="row">
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            2022
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                            <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-primary p-2"><i
                                                class="bx bx-dollar text-primary"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2022</small>
                                        <h6 class="mb-0">$32.5k</h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="me-2">
                                        <span class="badge bg-label-info p-2"><i
                                                class="bx bx-wallet text-info"></i></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>2021</small>
                                        <h6 class="mb-0">$41.2k</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="card">
                    <div class="card-header ">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Route Price</h5>
                            <small class="text-muted float-end">Tarif semua rute mapsline</small>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-secondary" role="alert">
                            <form action="">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Jenis</label>
                                    <div class="col-sm-10">
                                        <select class="form-select laravel-select2" id="basic-default-name"
                                            placeholder="John Doe">
                                            <option value="">Lokal</option>
                                            <option value="">Internasional</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary">Pratinjau</button>
                                </div>
                                <small class="text-muted">Anda dapat upload atau edit daftar tarif (excel)</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var userRole = "{{ auth()->user()->role->code_roles }}";

            // Format rupiah function from previous code
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, '');
                var split = number_string.split(',');
                var sisa = split[0].length % 3;
                var rupiah = split[0].substr(0, sisa);
                var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return 'Rp ' + rupiah + (split[1] !== undefined ? ',' + split[1] : '');
            }

            // Dapatkan elemen
            var totalBelumTerbayarElement = document.getElementById('data-total-belum-terbayar');
            var totalSudahTerbayarElement = document.getElementById('data-total-sudah-terbayar');

            // Format nilai dan atur kembali ke elemen
            totalBelumTerbayarElement.textContent = formatRupiah(totalBelumTerbayarElement.textContent);
            totalSudahTerbayarElement.textContent = formatRupiah(totalSudahTerbayarElement.textContent);
        });
    </script>
@endpush
