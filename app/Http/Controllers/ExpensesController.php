<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Categories;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpensesController extends Controller
{
    // Halaman List Pengeluaran
    public function index()
    {
        $expenses = Expenses::getAll();
        $categories = Categories::getAll();
        return view('dashboard.expenses.list', compact('expenses', 'categories'));
    }

    // Halaman Tambah Pengeluaran
    public function addPage()
    {
        // Ambil kategori dengan tipe 'Pengeluaran'
        $categories = Categories::where('type', 'expense')->get();
        return view('dashboard.expenses.add', compact('categories'));
    }

    // Tambah Pengeluaran
    public function insert(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'id_category' => 'required|exists:categories,id_category',
        ]);

        // Insert data ke table
        $expense = Expenses::insert([
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'id_category' => $request->id_category,
            'created_at' => now(),
        ]);

        // Cek jika berhasil
        if ($expense) {
            return redirect()->route('expenses')->with('success', 'Data Telah ditambahkan');
        } else {
            return redirect()->route('expenses')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    // Update pada method editPage dan update untuk menggunakan id_expense
    public function editPage($id_expense)
    {
        $expense = Expenses::getById($id_expense); // Cari data pengeluaran berdasarkan id_expense
        $categories = Categories::where('type', 'expense')->get(); // Ambil type kategori
        return view('dashboard.expenses.edit', compact('expense', 'categories'));
    }

    // Update pada method update
    public function update(Request $request, $id_expense)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'id_category' => 'required|exists:categories,id_category',
        ]);

        $update = Expenses::where('id_expense', $id_expense)->update([ // Gunakan id_expense sebagai referensi
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'id_category' => $request->id_category,
        ]);

        if ($update) {
            return redirect()->route('expenses')->with('success', 'Data Berhasil Diperbarui');
        } else {
            return redirect()->route('expenses')->with('error', 'Data Gagal Diperbarui');
        }
    }

    // Update pada method delete
    public function delete($id_expense)
    {
        // Hapus data pengeluaran berdasarkan id_expense
        $expense = Expenses::getById($id_expense);

        if ($expense) {
            // Hapus pengeluaran
            $expense->where('id_expense', $id_expense)->delete();

            // Notifikasi
            return redirect()->route('expenses')->with('success', 'Data Pengeluaran Telah Dihapus');
        } else {
            return redirect()->route('expenses')->with('error', 'Data Pengeluaran Tidak Ditemukan');
        }
    }

    public function exportPDF()
    {
        // Ambil data terbaru untuk laporan
        $expense = Expenses::getAll(); // Semua data pemasukan
        $categories = Categories::getAll(); // Semua kategori pemasukan

        // Format total pemasukan
        $totalExpense = $expense->sum('amount');

        // Format data periode (dapat disesuaikan jika memiliki tabel periode)
        $formattedPeriods = 'Awal - Akhir Periode'; // Ganti dengan periode dinamis jika tersedia

        // Data untuk dikirimkan ke tampilan PDF
        $data = [
            'expenses' => $expense,
            'categories' => $categories,
            'totalExpense' => $totalExpense,
            'formattedPeriods' => $formattedPeriods,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('dashboard.expenses.report', $data);

        // Download laporan PDF
        return $pdf->download('Laporan_Pemasukan.pdf');
    }

    public function exportWeeklyPDF()
    {
        // Ambil data untuk satu minggu terakhir
        $startOfWeek = now()->startOfWeek(); // Awal minggu (Senin)
        $endOfWeek = now()->endOfWeek(); // Akhir minggu (Minggu)

        $expenses = Expenses::whereBetween('date', [$startOfWeek, $endOfWeek])->get();
        $totalExpense = $expenses->sum('amount');

        $data = [
            'expenses' => $expenses,
            'totalExpense' => $totalExpense,
            'period' => $startOfWeek->format('d M Y') . ' - ' . $endOfWeek->format('d M Y'),
        ];

        // Generate PDF
        $pdf = Pdf::loadView('dashboard.expenses.weekly_report', $data);

        // Simpan file PDF
        $fileName = 'Laporan_Pengeluaran_Mingguan_' . now()->format('Y_m_d') . '.pdf';
        $filePath = storage_path('app/public/reports/' . $fileName);
        $pdf->save($filePath);

        return $filePath;
    }
}
