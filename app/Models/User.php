<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity; // <-- 1. IMPORT TRAIT
use Spatie\Activitylog\LogOptions; // <-- 2. IMPORT LOG OPTIONS

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity; // <-- 3. GUNAKAN TRAIT DI SINI

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // DOKUMENTASI: Blok ini memberi tahu logger apa saja yang harus dicatat
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Catat hanya field 'name' dan 'email'
            ->logOnly(['name', 'email'])
            // Kita hanya peduli saat user 'created' (registrasi)
            ->logEvents(['created'])
            // Beri deskripsi
            ->setDescriptionForEvent(fn(string $eventName) => "User baru telah mendaftar")
            ->dontSubmitEmptyLogs();
    }
}