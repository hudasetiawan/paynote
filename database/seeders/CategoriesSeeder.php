<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Pemasukan (Income)
            ['name_category' => 'Gaji Utama', 'type' => 'income'],
            ['name_category' => 'Freelance & Projek', 'type' => 'income'],
            ['name_category' => 'Investasi & Dividen', 'type' => 'income'],
            ['name_category' => 'Bonus & Tunjangan', 'type' => 'income'],
            ['name_category' => 'Penjualan & Bisnis', 'type' => 'income'],
            ['name_category' => 'Pemasukan Lainnya', 'type' => 'income'],

            // Pengeluaran (Expense)
            ['name_category' => 'Makanan & Minuman', 'type' => 'expense'],
            ['name_category' => 'Transportasi & Bensin', 'type' => 'expense'],
            ['name_category' => 'Tagihan & Utilitas', 'type' => 'expense'],
            ['name_category' => 'Belanja & Pakaian', 'type' => 'expense'],
            ['name_category' => 'Kesehatan & Medis', 'type' => 'expense'],
            ['name_category' => 'Hiburan & Rekreasi', 'type' => 'expense'],
            ['name_category' => 'Edukasi & Pengembangan Diri', 'type' => 'expense'],
            ['name_category' => 'Pengeluaran Lainnya', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                [
                    'name_category' => $category['name_category'],
                    'type' => $category['type'],
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

