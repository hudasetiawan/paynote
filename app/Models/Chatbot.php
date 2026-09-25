<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    use HasFactory;

    protected $table = 'chatbot';
    protected $fillable = ['queries', 'replies']; // Sesuaikan dengan kolom yang relevan
    public $timestamps = true; // Untuk menggunakan kolom `created_at` dan `updated_at`
}
