<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID Kategori Pemasukan & Pengeluaran
        $incomeCategories = DB::table('categories')->where('type', 'income')->pluck('id_category', 'name_category')->toArray();
        $expenseCategories = DB::table('categories')->where('type', 'expense')->pluck('id_category', 'name_category')->toArray();

        if (empty($incomeCategories) || empty($expenseCategories)) {
            $this->command->error('Kategori belum di-seed! Jalankan CategoriesSeeder terlebih dahulu.');
            return;
        }

        // Tanggal rujukan (sekarang)
        $now = Carbon::now();

        // --- DUMMY DATA PEMASUKAN (INCOMES) ---
        // Catatan: decimal(8,2) memiliki batas nilai maksimum 999,999.99 per entri.
        $incomesData = [
            [
                'amount' => 750000.00,
                'description' => 'Gaji Mingguan Ke-1',
                'date' => $now->copy()->subWeeks(4)->format('Y-m-d'),
                'id_category' => $incomeCategories['Gaji Utama'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 350000.00,
                'description' => 'Project Landing Page Client',
                'date' => $now->copy()->subWeeks(4)->addDays(2)->format('Y-m-d'),
                'id_category' => $incomeCategories['Freelance & Projek'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 750000.00,
                'description' => 'Gaji Mingguan Ke-2',
                'date' => $now->copy()->subWeeks(3)->format('Y-m-d'),
                'id_category' => $incomeCategories['Gaji Utama'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 200000.00,
                'description' => 'Dividen Reksa Dana',
                'date' => $now->copy()->subWeeks(3)->addDays(3)->format('Y-m-d'),
                'id_category' => $incomeCategories['Investasi & Dividen'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 750000.00,
                'description' => 'Gaji Mingguan Ke-3',
                'date' => $now->copy()->subWeeks(2)->format('Y-m-d'),
                'id_category' => $incomeCategories['Gaji Utama'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 500000.00,
                'description' => 'Bonus Performa Akhir Bulan',
                'date' => $now->copy()->subWeeks(2)->addDays(4)->format('Y-m-d'),
                'id_category' => $incomeCategories['Bonus & Tunjangan'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 750000.00,
                'description' => 'Gaji Mingguan Ke-4',
                'date' => $now->copy()->subWeek()->format('Y-m-d'),
                'id_category' => $incomeCategories['Gaji Utama'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 450000.00,
                'description' => 'Desain Banner Promosi',
                'date' => $now->copy()->subDays(3)->format('Y-m-d'),
                'id_category' => $incomeCategories['Freelance & Projek'] ?? reset($incomeCategories),
            ],
            [
                'amount' => 150000.00,
                'description' => 'Hasil Penjualan Barang Bekas',
                'date' => $now->copy()->subDays(1)->format('Y-m-d'),
                'id_category' => $incomeCategories['Penjualan & Bisnis'] ?? reset($incomeCategories),
            ],
        ];

        // --- DUMMY DATA PENGELUARAN (EXPENSES) ---
        $expensesData = [
            [
                'amount' => 85000.00,
                'description' => 'Belanja Sayur & Buah Mingguan',
                'date' => $now->copy()->subWeeks(4)->addDays(1)->format('Y-m-d'),
                'id_category' => $expenseCategories['Makanan & Minuman'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 120000.00,
                'description' => 'Isi Bensin Motor & Tol',
                'date' => $now->copy()->subWeeks(4)->addDays(3)->format('Y-m-d'),
                'id_category' => $expenseCategories['Transportasi & Bensin'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 250000.00,
                'description' => 'Tagihan Internet & Wi-Fi',
                'date' => $now->copy()->subWeeks(3)->addDays(1)->format('Y-m-d'),
                'id_category' => $expenseCategories['Tagihan & Utilitas'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 45000.00,
                'description' => 'Kopi & Makan Siang Kantor',
                'date' => $now->copy()->subWeeks(3)->addDays(4)->format('Y-m-d'),
                'id_category' => $expenseCategories['Makanan & Minuman'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 175000.00,
                'description' => 'Beli Baju & Kemeja Kerja',
                'date' => $now->copy()->subWeeks(2)->addDays(1)->format('Y-m-d'),
                'id_category' => $expenseCategories['Belanja & Pakaian'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 65000.00,
                'description' => 'Beli Vitamin & Obat Faskes',
                'date' => $now->copy()->subWeeks(2)->addDays(5)->format('Y-m-d'),
                'id_category' => $expenseCategories['Kesehatan & Medis'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 150000.00,
                'description' => 'Nonton Bioskop & Snack',
                'date' => $now->copy()->subWeek()->addDays(2)->format('Y-m-d'),
                'id_category' => $expenseCategories['Hiburan & Rekreasi'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 95000.00,
                'description' => 'Langganan Kursus Online Udemy',
                'date' => $now->copy()->subWeek()->addDays(4)->format('Y-m-d'),
                'id_category' => $expenseCategories['Edukasi & Pengembangan Diri'] ?? reset($expenseCategories),
            ],
            [
                'amount' => 60000.00,
                'description' => 'Makan Malam & Camilan',
                'date' => $now->copy()->subDays(2)->format('Y-m-d'),
                'id_category' => $expenseCategories['Makanan & Minuman'] ?? reset($expenseCategories),
            ],
        ];

        // Insert Incomes & update Balance
        foreach ($incomesData as $income) {
            DB::table('incomes')->insert([
                'amount' => $income['amount'],
                'description' => $income['description'],
                'date' => $income['date'],
                'id_category' => $income['id_category'],
                'created_at' => Carbon::parse($income['date'])->toDateTimeString(),
            ]);

            // Tambahkan ke tabel balance
            DB::table('balance')->insert([
                'amount' => $income['amount'],
                'updated_at' => Carbon::parse($income['date'])->toDateTimeString(),
            ]);
        }

        // Insert Expenses & update Balance
        foreach ($expensesData as $expense) {
            DB::table('expenses')->insert([
                'amount' => $expense['amount'],
                'description' => $expense['description'],
                'date' => $expense['date'],
                'id_category' => $expense['id_category'],
                'created_at' => Carbon::parse($expense['date'])->toDateTimeString(),
            ]);

            // Kurangkan ke tabel balance
            DB::table('balance')->insert([
                'amount' => -1 * $expense['amount'],
                'updated_at' => Carbon::parse($expense['date'])->toDateTimeString(),
            ]);
        }
    }
}
