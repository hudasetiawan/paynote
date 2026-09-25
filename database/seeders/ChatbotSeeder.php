<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatbotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'queries' => 'halo',
                'replies' => 'Halo! Selamat datang di Paynote App. Ada yang bisa saya bantu terkait keuangan Anda?',
            ],
            [
                'queries' => 'apa itu paynote',
                'replies' => 'Paynote adalah aplikasi pencatatan keuangan modern untuk memantau pemasukan, pengeluaran, dan saldo Anda secara efisien.',
            ],
            [
                'queries' => 'cara tambah pemasukan',
                'replies' => 'Untuk menambah pemasukan, navigasi ke menu Pemasukan di navigasi sebelah kiri lalu klik tombol "Tambah Data".',
            ],
            [
                'queries' => 'cara tambah pengeluaran',
                'replies' => 'Untuk menambah pengeluaran, navigasi ke menu Pengeluaran di navigasi sebelah kiri lalu klik tombol "Tambah Data".',
            ],
            [
                'queries' => 'bagaimana cara ekspor pdf',
                'replies' => 'Anda dapat mengunduh laporan PDF di halaman daftar Pemasukan atau Pengeluaran dengan menekan tombol "Export PDF".',
            ],
            [
                'queries' => 'kategori',
                'replies' => 'Fitur kategori membantu Anda mengelompokkan transaksi seperti Gaji, Makanan, Transportasi, dan Tagihan agar lebih mudah dianalisis.',
            ],
            [
                'queries' => 'lupa password',
                'replies' => 'Jika Anda mengalami masalah saat login atau lupa password, silakan hubungi Administrator Paynote.',
            ],
            [
                'queries' => 'terima kasih',
                'replies' => 'Sama-sama! Semoga Paynote membantu Anda mengelola keuangan dengan lebih baik.',
            ],
        ];

        foreach ($faqs as $faq) {
            DB::table('chatbot')->updateOrInsert(
                ['queries' => $faq['queries']],
                [
                    'replies' => $faq['replies'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
