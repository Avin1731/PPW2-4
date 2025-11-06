<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail; // <-- Import Mail
use App\Mail\WelcomeEmail; // <-- Import Mailable kita
use App\Models\User; // <-- Import Model User

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        // DOKUMENTASI: Terima objek User saat job dipanggil
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // DOKUMENTASI: Siapkan data (array) untuk email
        $userData = [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ];

        // Buat email baru
        $email = new WelcomeEmail($userData);

        // Kirim email ke alamat email user
        Mail::to($this->user->email)->send($email);
    }
}