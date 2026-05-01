<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory; // Disarankan untuk memudahkan testing/seeding

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'message',
    ];

    /**
     * Menghubungkan Chirp kembali ke User (Relasi Inverse)
     */
    public function user(): BelongsTo
    {
        // Pastikan User model ada di namespace App\Models
        return $this->belongsTo(User::class);
    }
}