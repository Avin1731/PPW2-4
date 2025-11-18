<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loker extends Model {
    protected $guarded = [];

    public function applies() {
        return $this->hasMany(Apply::class, 'loker_id'); // <-- Pastikan foreign key 'loker_id' ditulis
    }
}