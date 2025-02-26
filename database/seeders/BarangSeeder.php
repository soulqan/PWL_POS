<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run():void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 5500000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Smartphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'BRG003', 'barang_nama' => 'Headphone', 'harga_beli' => 500000, 'harga_jual' => 700000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Jaket', 'harga_beli' => 200000, 'harga_jual' => 300000],
            ['barang_id' => 5, 'kategori_id' => 2, 'barang_kode' => 'BRG005', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Mie Instan', 'harga_beli' => 2500, 'harga_jual' => 3500],
            ['barang_id' => 7, 'kategori_id' => 3, 'barang_kode' => 'BRG007', 'barang_nama' => 'Biskuit', 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Air Mineral', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['barang_id' => 9, 'kategori_id' => 4, 'barang_kode' => 'BRG009', 'barang_nama' => 'Kopi Instan', 'harga_beli' => 2000, 'harga_jual' => 4000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Rice Cooker', 'harga_beli' => 400000, 'harga_jual' => 500000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
