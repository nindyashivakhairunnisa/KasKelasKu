<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori', 'keterangan', 'jumlah',
        'tanggal', 'user_id', 'bukti'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function byKategori()
    {
        return static::select('kategori')
            ->selectRaw('SUM(jumlah) as total')
            ->groupBy('kategori')
            ->get();
    }
}