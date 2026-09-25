<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    // Show All Data (Separated by Type)
    public function index()
    {
        // Mengambil semua kategori dari database
        $categories = Categories::all();

        // Mengirim data kategori ke view
        return view('admin.categories.list', compact('categories'));
    }


    // Goto Add Data Page
    public function addPage()
    {
        $title = "Tambah Kategori";
        return view('admin.categories.add', compact('title'));
    }

    // Insert & Send Data to Model
    public function insert(Request $request)
    {
        // Validasi input
        $request->validate([
            'name_category' => 'required|string|max:255',
            'type' => 'required|in:income,expense', // Validasi tipe harus 'income' atau 'expense'
        ]);

        // Simpan data ke database
        Categories::create([
            'name_category' => $request->name_category,
            'type' => $request->type,
        ]);

        return redirect()->route('categories')->with('success', 'Data berhasil ditambahkan!');
    }

    // Go to Edit Data Page
    public function editPage($id)
    {
        $title = "Edit Kategori";
        // Menggunakan findOrFail untuk mencari kategori berdasarkan ID
        $category = Categories::findOrFail($id); // Gantilah getById dengan findOrFail
        return view('admin.categories.edit', compact('title', 'category'));
    }

    // Update Data via Model
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name_category' => 'required|string|max:255',
            'type' => 'required|in:income,expense', // Validasi tipe harus 'income' atau 'expense'
        ]);

        // Menggunakan findOrFail untuk mencari kategori berdasarkan ID
        $category = Categories::findOrFail($id); // Gantilah getById dengan findOrFail
        $category->update([
            'name_category' => $request->name_category,
            'type' => $request->type,
        ]);

        return redirect()->route('categories')->with('success', 'Data berhasil diubah!');
    }

    // Delete Data
    public function delete($id)
    {
        $category = Categories::findOrFail($id); // Mengambil kategori berdasarkan ID
        $category->delete(); // Menghapus kategori
        return redirect()->route('categories')->with('success', 'Data berhasil dihapus!');
    }

    // Menampilkan kategori pemasukan
    public function income()
    {
        $categories = Categories::where('type', 'income')->get();
        return view('admin.categories.income', compact('categories'));
    }

    // Menampilkan kategori pengeluaran
    public function expense()
    {
        $categories = Categories::where('type', 'expense')->get();
        return view('admin.categories.expense', compact('categories'));
    }
}
