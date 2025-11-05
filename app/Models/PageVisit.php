<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;
    
    // Tentukan nama tabelnya
    protected $table = 'page_visits';

    // Tentukan kolom yang boleh diisi
    protected $fillable = [
        'url',
        'ip_address',
        'user_agent',
        'user_id',
    ];
}