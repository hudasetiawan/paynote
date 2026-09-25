<?php

namespace App\Http\Controllers;

use App\Models\Incomes;
use App\Models\Expenses;
use App\Models\Balance;
use App\Models\Categories;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Ambil data mingguan untuk pemasukan dan pengeluaran
        $firstDateIncome = Incomes::min('date');
        $firstDateExpense = Expenses::min('date');

        $weeklyIncomes = Incomes::selectRaw('WEEK(DATE_SUB(date, INTERVAL WEEKOFYEAR(?) - 1 WEEK)) as week, SUM(amount) as total', [$firstDateIncome])
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get();

        $weeklyExpenses = Expenses::selectRaw('WEEK(DATE_SUB(date, INTERVAL WEEKOFYEAR(?) - 1 WEEK)) as week, SUM(amount) as total', [$firstDateExpense])
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get();

        // Ambil total pemasukan, pengeluaran, dan kategori
        $total_incomes = Incomes::totalIncomes();
        $total_balance = Balance::totalBalance();
        $total_categories = Categories::totalCategories();
        $total_expenses = Expenses::totalExpenses();
        $incomesAndExpenses = Balance::getAllIncomesAndExpenses();
        $categories = Categories::getAll();

        // Cek saldo untuk notifikasi
        $lowBalanceWarning = $total_balance < 100000 ? "Saldo Anda kurang dari 100 ribu. Harap waspada terhadap pengeluaran." : null;

        $data = [
            'total_incomes' => $total_incomes,
            'total_balance' => $total_balance,
            'total_categories' => $total_categories,
            'total_expenses' => $total_expenses,
            'incomesAndExpenses' => $incomesAndExpenses,
            'categories' => $categories,
            'weeklyIncomes' => $weeklyIncomes,
            'weeklyExpenses' => $weeklyExpenses,
            'lowBalanceWarning' => $lowBalanceWarning, // Tambahkan ke data view
        ];

        return view('dashboard.index', $data);
    }
}
