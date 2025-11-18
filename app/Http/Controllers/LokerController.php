<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loker;
use App\Models\Apply;
use Illuminate\Support\Facades\Auth;

class LokerController extends Controller
{
    // 1. Menampilkan halaman list loker
    public function index() 
    {
        // PENTING: Set paginate(8) agar pas 2 baris (4 kartu x 2 baris)
        $jobs = Loker::where('is_active', true)->latest()->paginate(8);
        
        $appliedJobs = [];
        if (Auth::check()) {
            $appliedJobs = Apply::where('user_id', Auth::id())
                            ->pluck('loker_id')
                            ->toArray();
        }

        return view('loker.index', compact('jobs', 'appliedJobs'));
    }

    // 2. Proses Upload CV
    public function store(Request $request, $lokerId) 
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048', 
            'position' => 'required|string' 
        ]);

        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'public'); 
        }

        Apply::create([
            'loker_id' => $lokerId,
            'user_id'  => auth()->id(),
            'cv_path'  => $path,
            'selected_position' => $request->position 
        ]);

        return redirect()->back()->with('success', 'Lamaran untuk posisi ' . $request->position . ' berhasil dikirim!');
    }
}