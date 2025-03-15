<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'm_kategori'; // Pastikan nama tabel sesuai
    protected $primaryKey = 'kategori_id'; // Sesuai dengan primary key di database
    public $timestamps = false; // Jika tidak ada kolom created_at dan updated_at

    protected $fillable = [
        'kategori_kode',
        'kategori_nama'
    ];
}
