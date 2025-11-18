<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings; // <-- Import WithHeadings
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // <-- Import AutoSize
use Maatwebsite\Excel\Concerns\WithStyles; // <-- Import WithStyles (Opsional, biar header tebal)
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LokerTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return array
    */
    public function array(): array
    {
        // DOKUMENTASI: Data dummy (contoh) agar admin tahu cara mengisinya.
        // Format tanggal disarankan YYYY-MM-DD.
        return [
            [
                'Software Engineer', 
                'Mengembangkan aplikasi web yang scalable dan aman...', 
                'Frontend Dev, Backend Dev, DevOps', // Contoh pengisian multi-posisi dipisah koma
                'Jakarta Selatan (Hybrid)', 
                '2025-12-31'
            ],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // DOKUMENTASI: Ini adalah baris header (Judul kolom) di Excel.
        // Penamaan harus sesuai dengan key yang ada di LokerImport.php
        return [
            'title', 
            'description', 
            'available_positions', // Kolom baru untuk multi-posisi
            'location', 
            'deadline'
        ];
    }

    /**
     * DOKUMENTASI: Styling tambahan agar Header (Baris 1) terlihat tebal.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}