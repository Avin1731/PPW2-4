<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity; // Import Trait
use Spatie\Activitylog\LogOptions; // Import Log Options

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity; // Gunakan Trait

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

    // DOKUMENTASI: Kita aktifkan lagi fungsinya (un-comment)
    // agar tidak error "abstract method"
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Catat hanya field 'name' dan 'email'
            ->logOnly(['name', 'email'])
            
            // DOKUMENTASI: Baris ->logEvents() kita HAPUS
            // karena itu yang menyebabkan error versi
            
            // Beri deskripsi
            ->setDescriptionForEvent(fn(string $eventName) => "User baru telah mendaftar")
            ->dontSubmitEmptyLogs();
    }
}