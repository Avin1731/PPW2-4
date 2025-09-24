<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus'; // sesuaikan dengan nama tabel di migration
    protected $fillable = ['title', 'writer', 'price', 'published_date'];
}
