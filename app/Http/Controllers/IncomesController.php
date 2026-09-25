<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incomes;
use App\Models\Balance;
use App\Models\Categories;
use Barryvdh\DomPDF\Facade\Pdf;

class IncomesController extends Controller
{
    // Menampilkan Semua Data
    public function index()
    {
        $incomes = Incomes::getAll(); // Ambil semua data pemasukan
        $categories = Categories::getAll(); // Ambil semua data kategori
        return view('dashboard.incomes.list', compact('incomes', 'categories'));
    }

    // Goto Add Data Page
    public function addPage()
    {
        $title = "Tambah Data Pemasukan";
        // Ambil kategori yang tipe-nya 'income' (pemasukan)
        $categories = Categories::where('type', 'income')->get(); // Filter hanya kategori dengan type 'income'
        return view('dashboard.incomes.add', compact('title', 'categories'));
    }

    // Insert Data
    public function insert(Request $request)
    {

        // Masukkan catatan pendapatan baru ke dalam database.
        $income = Incomes::insert([
            'amount'        => $request->amount,
            'description'   => $request->description,
            'date'          => $request->date,
            'id_category'   => $request->id_category,
            'created_at'    => now(),
        ]);

        // Notifikasi
        if ($income) {
            return redirect()->route('incomes')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('incomes')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    // Edit Page
    public function editPage($id)
    {
        $income = Incomes::getById($id); // Cari data pemasukan berdasarkan ID
        $categories = Categories::where('type', 'income')->get(); // Ambil semua type kategori
        return view('dashboard.incomes.edit', compact('income', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'id_category' => 'required|exists:categories,id_category',
        ]);

        $update = Incomes::where('id_income', $id)->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'id_category' => $request->id_category,
        ]);

        if ($update) {
            return redirect()->route('incomes')->with('success', 'Data Berhasil Diperbarui');
        } else {
            return redirect()->route('incomes')->with('error', 'Data Gagal Diperbarui');
        }
    }

    // Delete Data
    public function delete($id)
    {
        // Hapus data pendapatan berdasarkan id
        $income = Incomes::deleteData($id);

        // Notifikasi
        if ($income) {
            return redirect()->route('incomes')->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->route('incomes')->with('error', 'Data Gagal Dihapus');
        }
    }

    public function exportPDF()
    {
        // Ambil data terbaru untuk laporan
        $incomes = Incomes::getAll(); // Semua data pemasukan
        $categories = Categories::getAll(); // Semua kategori pemasukan

        // Format total pemasukan
        $totalIncome = $incomes->sum('amount');

        // Format data periode (dapat disesuaikan jika memiliki tabel periode)
        $formattedPeriods = 'Awal - Akhir Periode'; // Ganti dengan periode dinamis jika tersedia

        // Data untuk dikirimkan ke tampilan PDF
        $data = [
            'incomes' => $incomes,
            'categories' => $categories,
            'totalIncome' => $totalIncome,
            'formattedPeriods' => $formattedPeriods,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('dashboard.incomes.report', $data);

        // Download laporan PDF
        return $pdf->download('Laporan_Pemasukan.pdf');
    }
}
