<?php

namespace App\Exports; // <-- Namespace Wajib Ada

use App\Models\Apply;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplyExport implements FromCollection, WithHeadings, WithMapping
{
    protected $lokerId;

    public function __construct($lokerId) {
        $this->lokerId = $lokerId;
    }

    public function collection() {
        return Apply::with('user')->where('loker_id', $this->lokerId)->get();
    }

    public function map($apply): array {
        return [
            $apply->user->name,
            $apply->user->email,
            $apply->selected_position ?? '-', // <--- Tampilkan posisi yang dipilih
            $apply->created_at->format('d-m-Y'),
            asset('storage/' . $apply->cv_path), 
        ];
    }

    public function headings(): array {
        return ['Nama Pelamar', 'Email', 'Posisi Dilamar', 'Tanggal Apply', 'Link CV'];
    }
}