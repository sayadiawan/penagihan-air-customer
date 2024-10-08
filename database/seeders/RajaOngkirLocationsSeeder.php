<?php

namespace Database\Seeders;

use App\Models\CityRajaOngkir;
use App\Models\ProvinceRajaOngkir;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class RajaOngkirLocationsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $daftarProvinsi = RajaOngkir::provinsi()->all();
    foreach ($daftarProvinsi as $provinceRow) {
      ProvinceRajaOngkir::create([
        'province_id' => $provinceRow['province_id'],
        'name'        => $provinceRow['province'],
      ]);

      $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
      foreach ($daftarKota as $cityRow) {
        CityRajaOngkir::create([
          'province_id'   => $provinceRow['province_id'],
          'city_id'       => $cityRow['city_id'],
          'name'          => $cityRow['city_name'],
        ]);
      }
    }
  }
}