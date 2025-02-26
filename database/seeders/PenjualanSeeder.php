<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 1, 'pembeli' => 'Andi', 'penjualan_kode' => 'TRX001', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 2, 'user_id' => 2, 'pembeli' => 'Budi', 'penjualan_kode' => 'TRX002', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 3, 'user_id' => 3, 'pembeli' => 'Citra', 'penjualan_kode' => 'TRX003', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 4, 'user_id' => 1, 'pembeli' => 'Dewi', 'penjualan_kode' => 'TRX004', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 5, 'user_id' => 2, 'pembeli' => 'Eko', 'penjualan_kode' => 'TRX005', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 6, 'user_id' => 3, 'pembeli' => 'Fajar', 'penjualan_kode' => 'TRX006', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 7, 'user_id' => 1, 'pembeli' => 'Gina', 'penjualan_kode' => 'TRX007', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 8, 'user_id' => 2, 'pembeli' => 'Hadi', 'penjualan_kode' => 'TRX008', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 9, 'user_id' => 3, 'pembeli' => 'Indah', 'penjualan_kode' => 'TRX009', 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 10, 'user_id' => 1, 'pembeli' => 'Joko', 'penjualan_kode' => 'TRX010', 'penjualan_tanggal' => Carbon::now()],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
