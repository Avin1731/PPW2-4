<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmailJob; // <-- DOKUMENTASI: 1. Import Job kita

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        // Hanya tamu (belum login) yang boleh ke login & register
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    // 🔹 Halaman Register
    public function register()
    {
        return view('auth.register');
    }

    // 🔹 Proses Registrasi
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        // DOKUMENTASI: 2. Buat user baru DAN simpan di variabel $user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' akan otomatis 'user' karena default di database
        ]);

        // DOKUMENTASI: 3. Panggil Job dan masukkan ke antrian
        // Kirimkan objek $user yang baru dibuat ke Job
        try {
            SendWelcomeEmailJob::dispatch($user);
        } catch (\Exception $e) {
            // Jika antrian gagal (misal .env salah),
            // jangan gagalkan registrasi. Cukup catat errornya.
            report($e);
        }

        // Redirect ke login dengan flash message sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login. Cek email Anda untuk konfirmasi.');
    }

    // 🔹 Halaman Login
    public function login()
    {
        return view('auth.login');
    }

    // 🔹 Proses Login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 🔹 Dashboard
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('welcome');
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Berhasil logout.');
    }
}