<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\DetailPembelianBuku;
use App\Distributor;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianBuku extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $table = 'pembelian_buku';
    protected $fillable = ['kode', 'tanggal', 'id_user', 'id_distributor', 'total_harga', 'bayar', 'faktur', 'keterangan'];

    public function detail()
    {
        return $this->hasMany(DetailPembelianBuku::class, 'id_pembelian');
    }

    public function distributor()
    {
        return $this->hasOne(Distributor::class, 'id', 'id_distributor');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
