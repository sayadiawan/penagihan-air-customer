<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $is_akses = Auth::user()->role->code_roles;

    $tahun_now = Carbon::now()->year;
    $bulan_now = Carbon::now()->month;

    $totalBelumTerbayar = Tagihan::whereNull('bayar')
      ->where('bulan', $bulan_now)
      ->where('tahun', $tahun_now)
      ->sum('total_tagihan');

    $totalSudahTerbayar = Tagihan::whereNotNull('bayar')
      ->where('bulan', $bulan_now)
      ->where('tahun', $tahun_now)
      ->sum('total_tagihan');

    // Hitung jumlah pelanggan yang belum terbayar
    $jumlahPelangganBelumTerbayar = Customer::leftJoin('tagihans', function ($join) {
      $join->on('tagihans.user_id', '=', 'customers.users_id');
    })
      ->whereNull('tagihans.bayar')
      ->where('tagihans.bulan', Carbon::now()->month)
      ->where('tagihans.tahun', Carbon::now()->year)
      ->distinct('customers.users_id') // Pastikan hanya menghitung pelanggan unik
      ->count('customers.users_id'); // Hitung jumlah pelanggan

    // Hitung jumlah pelanggan yang sudah terbayar
    $jumlahPelangganSudahTerbayar = Customer::leftJoin('tagihans', function ($join) {
      $join->on('tagihans.user_id', '=', 'customers.users_id');
    })
      ->whereNotNull('tagihans.bayar')
      ->where('tagihans.bulan', Carbon::now()->month)
      ->where('tagihans.tahun', Carbon::now()->year)
      ->distinct('customers.users_id') // Pastikan hanya menghitung pelanggan unik
      ->count('customers.users_id'); // Hitung jumlah pelanggan

    /* if ($is_akses == "SAS" || $is_akses == "ADM") {
        return view('admin.pages.home.index');
    } else {
        abort(404);
    } */


    return view('admin.pages.home.index', compact('totalBelumTerbayar', 'totalSudahTerbayar', 'jumlahPelangganBelumTerbayar', 'jumlahPelangganSudahTerbayar'));
  }
}
