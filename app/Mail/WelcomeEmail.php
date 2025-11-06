<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $userData) // Pastikan tipenya array
    {
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static // Gunakan method build() yang stabil
    {
        // DOKUMENTASI: Atur subjek dan view-nya di sini
        return $this->subject('Selamat Datang di Pustaka Buku, ' . $this->userData['name'])
                    ->view('emails.welcome'); // Menggunakan view emails.welcome
    }
}