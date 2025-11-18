<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity; 
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\BukuExport; 
use App\Models\PageVisit; // Import model PageVisit

class AnalyticsController extends Controller
{
    /**
     * Menampilkan dashboard analisis utama (Grafik).
     */
    public function index()
    {
        // 1. Data untuk Kartu Statistik
        $totalUsers = User::count();
        $totalBuku = Buku::count();
        $totalVisits = PageVisit::count(); 

        // 2. Data untuk Grafik Pendaftaran User (30 hari terakhir)
        $usersPerDay = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        $chartLabels = $usersPerDay->pluck('date');
        $chartData = $usersPerDay->pluck('total');

        // DOKUMENTASI: 3. (BARU) Data untuk Grafik Kunjungan Halaman (30 hari terakhir)
        $visitsPerDay = PageVisit::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        $visitChartLabels = $visitsPerDay->pluck('date');
        $visitChartData = $visitsPerDay->pluck('total');
        // --- BATAS TAMBAHAN ---

        return view('admin.analytics', compact(
            'totalUsers',
            'totalBuku',
            'totalVisits',
            'chartLabels',
            'chartData',
            'visitChartLabels', // <-- Kirim data baru
            'visitChartData'  // <-- Kirim data baru
        ));
    }

    /**
     * Menampilkan halaman riwayat pendaftaran user.
     */
    public function userHistory()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.history_users', compact('users'));
    }

    /**
     * Menampilkan riwayat aktivitas.
     */
    public function activityHistory()
    {
        $activities = Activity::with('causer')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.history_activity', compact('activities'));
    }

    /**
     * Mengunduh laporan buku (Excel).
     */
    public function downloadBukuExcel()
    {
        return Excel::download(new BukuExport, 'laporan_buku_pustaka.xlsx');
    }

    public function uploadBukuExcel(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'buku_excel' => 'required|file|mimes:xlsx,csv,ods',
        ]);

        $file = $request->file('buku_excel');

        try {
            Excel::import(new \App\Imports\BukuImport, $file);
            return redirect()->back()->with('success', 'Data buku berhasil diimpor dari file Excel.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}