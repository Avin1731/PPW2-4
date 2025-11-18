<?php

namespace App\Imports;

use App\Models\Loker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // Import class Date
use Carbon\Carbon; // Import Carbon

class LokerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Loker([
            'title'               => $row['title'],
            'description'         => $row['description'],
            'available_positions' => $row['available_positions'] ?? $row['positions'] ?? null, 
            'location'            => $row['location'],
            
            // === PERBAIKAN LOGIC TANGGAL ===
            'deadline'            => $this->transformDate($row['deadline']),
        ]);
    }

    /**
     * Fungsi Helper untuk mengubah tanggal Excel (Angka) atau Teks menjadi format Database
     */
    private function transformDate($value)
    {
        if (!$value) return null;

        try {
            // 1. Jika formatnya Angka Serial Excel (contoh: 45290)
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value);
            }

            // 2. Jika formatnya Teks (contoh: "2025-12-31" atau "31-12-2025")
            return Carbon::parse($value);
        } catch (\Exception $e) {
            // Jika format tanggal aneh/gagal, return null atau tanggal hari ini
            return null; 
        }
    }
}