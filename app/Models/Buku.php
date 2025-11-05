<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; // <-- 1. IMPORT TRAIT
use Spatie\Activitylog\LogOptions; // <-- 2. IMPORT LOG OPTIONS

class Buku extends Model
{
    use HasFactory, LogsActivity; // <-- 3. GUNAKAN TRAIT DI SINI

    protected $table = 'bukus'; 
    protected $fillable = ['title', 'writer', 'price', 'published_date'];

    // DOKUMENTASI: Blok ini memberi tahu logger apa saja yang harus dicatat
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Catat hanya field-field ini
            ->logOnly(['title', 'writer', 'price', 'published_date'])
            // Hanya catat jika ada perubahan (tidak mencatat jika "update" tapi tidak ada yg diubah)
            ->logOnlyDirty()
            // Beri deskripsi pada log
            ->setDescriptionForEvent(fn(string $eventName) => "Data buku telah di-{$eventName}")
            // Jangan simpan log kosong
            ->dontSubmitEmptyLogs();
    }
}