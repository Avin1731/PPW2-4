<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookApiController extends Controller
{
    public function index()
    {
        // Get data buku, urutkan terbaru, dan paginate 5 per halaman
        $books = Buku::latest()->paginate(5);

        // Return collection of books as a resource
        return new BookResource(true, 'List Data Buku', $books);
    }
}