<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apply extends Model {
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi ke Loker
    public function loker() {
        return $this->belongsTo(Loker::class, 'loker_id'); // <-- Pastikan foreign key 'loker_id' ditulis
    }
}