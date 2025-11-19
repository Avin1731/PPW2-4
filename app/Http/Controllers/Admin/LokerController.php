<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loker;
use App\Models\Apply;           // <--- Tambahkan Model Apply
use App\Imports\LokerImport;
use App\Exports\LokerTemplateExport; 
use App\Exports\ApplyExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class LokerController extends Controller
{
    // ... (Fungsi index, import, downloadTemplate TETAP SAMA, jangan dihapus) ...
    
    public function index()
    {
        $lokers = Loker::withCount('applies')->latest()->paginate(8);
        return view('admin.lokers.index', compact('lokers'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new LokerTemplateExport, 'template_loker.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xls,xlsx,csv']);
        try {
            Excel::import(new LokerImport, $request->file('file'));
            return back()->with('success', 'Data loker berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function exportApplicants($lokerId)
    {
        $loker = Loker::findOrFail($lokerId);
        return Excel::download(new ApplyExport($lokerId), 'pelamar-' . Str::slug($loker->title) . '.csv');
    }

    // --- FUNGSI BARU DI BAWAH INI ---

    // 1. Menampilkan Halaman Detail Pelamar
    public function showApplicants($lokerId)
    {
        $loker = Loker::findOrFail($lokerId);
        
        // Ambil pelamar, urutkan dari yang terbaru
        $applicants = Apply::with('user')
                        ->where('loker_id', $lokerId)
                        ->latest()
                        ->paginate(10);

        return view('admin.lokers.applicants', compact('loker', 'applicants'));
    }

    // 2. Proses Update Status (Terima/Tolak)
    public function updateStatus(Request $request, $applyId)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,pending'
        ]);

        $apply = Apply::findOrFail($applyId);
        $apply->update([
            'status' => $request->status
        ]);

        $statusMsg = $request->status == 'accepted' ? 'diterima' : 'ditolak';

        return back()->with('success', 'Pelamar berhasil ' . $statusMsg);
    }

    // [BARU] Tampilkan Form Edit
    public function edit($id)
    {
        $loker = Loker::findOrFail($id);
        return view('admin.lokers.edit', compact('loker'));
    }

    // [BARU] Proses Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string',
            'deadline'    => 'nullable|date',
            'available_positions' => 'nullable|string', // Validasi untuk posisi
        ]);

        $loker = Loker::findOrFail($id);
        $loker->update($request->all());

        return redirect()->route('admin.lokers.index')->with('success', 'Loker berhasil diperbarui!');
    }
}