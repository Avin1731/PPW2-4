<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // <-- 1. Import WithHeadings
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // <-- 2. Import AutoSize

class BukuExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // DOKUMENTASI: Ambil data yang ingin diekspor.
        // Kita hanya ambil kolom-kolom ini saja.
        return Buku::select('id', 'title', 'writer', 'price', 'published_date')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // DOKUMENTASI: Ini adalah baris header (Judul kolom) di Excel
        return [
            'ID',
            'Judul',
            'Penulis',
            'Harga',
            'Tanggal Terbit',
        ];
    }
}