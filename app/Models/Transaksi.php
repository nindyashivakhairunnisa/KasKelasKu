<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'keterangan', 'tipe', 'jumlah',
        'siswa_id', 'user_id', 'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function totalPemasukan()
    {
        return static::where('tipe', 'masuk')->sum('jumlah');
    }

    public static function totalPengeluaran()
    {
        return static::where('tipe', 'keluar')->sum('jumlah');
    }

    public static function saldo()
    {
        return static::totalPemasukan() - static::totalPengeluaran();
    }
}