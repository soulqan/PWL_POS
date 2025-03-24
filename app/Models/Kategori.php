<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'm_kategori'; // Pastikan sesuai dengan database
    protected $primaryKey = 'kategori_id'; // PK yang benar
    public $timestamps = false; // Karena created_at & updated_at NULL

    protected $fillable = ['kategori_id', 'kategori_kode', 'kategori_nama'];
}


