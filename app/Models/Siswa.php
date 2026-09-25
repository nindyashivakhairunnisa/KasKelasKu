<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nis', 'kelas', 'no_absen',
        'jenis_kelamin', 'no_hp', 'alamat', 'status'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function totalKas()
    {
        return $this->pembayarans()
            ->where('status', 'lunas')
            ->sum('jumlah');
    }
}