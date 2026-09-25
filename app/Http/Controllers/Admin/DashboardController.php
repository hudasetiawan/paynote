<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        // Ambil jumlah pengguna
        $total_users = User::count();

        $totalCategoriesIncomes = Categories::where('type', 'income')->count();
        $totalCategoriesExpenses = Categories::where('type', 'expense')->count();

        $totalCategoriesIncomesUsed = Categories::join('incomes', 'categories.id_category', '=', 'incomes.id_category')
            ->select('categories.id_category', 'categories.name_category', DB::raw('COUNT(incomes.id_income) as total_used'))
            ->groupBy('categories.id_category', 'categories.name_category')
            ->orderBy('total_used', 'desc') 
            ->get();

        $totalCategoriesExpensesUsed = Categories::join('expenses', 'categories.id_category', '=', 'expenses.id_category')
            ->select('categories.id_category', 'categories.name_category', DB::raw('COUNT(expenses.id_expense) as total_used'))
            ->groupBy('categories.id_category', 'categories.name_category')
            ->orderBy('total_used', 'desc') 
            ->get();

        // Ambil data total
        $total_incomes = Incomes::sum('amount');
        $total_balance = Balance::sum('amount');
        $total_categories = Categories::count();
        $total_expenses = Expenses::sum('amount');

        // Data mingguan untuk pemasukan dan pengeluaran
        $weeklyIncomes = Incomes::selectRaw('WEEK(date) as week, SUM(amount) as total')
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get();

        $weeklyExpenses = Expenses::selectRaw('WEEK(date) as week, SUM(amount) as total')
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get();

        // Ambil semua pemasukan dan pengeluaran (opsional)
        $incomesAndExpenses = [
            'incomes' => Incomes::all(),
            'expenses' => Expenses::all()
        ];

        // Ambil data kategori
        $categories = Categories::all();

        $data = [
            'total_users' => $total_users,
            'totalCategoriesIncomes' => $totalCategoriesIncomes,
            'totalCategoriesExpenses' => $totalCategoriesExpenses,
            'totalCategoriesIncomesUsed' => $totalCategoriesIncomesUsed,
            'totalCategoriesExpensesUsed' => $totalCategoriesExpensesUsed,
            'total_incomes' => $total_incomes,
            'total_balance' => $total_balance,
            'total_categories' => $total_categories,
            'total_expenses' => $total_expenses,
            'incomesAndExpenses' => $incomesAndExpenses,
            'categories' => $categories,
            'weeklyIncomes' => $weeklyIncomes,
            'weeklyExpenses' => $weeklyExpenses,
        ];

        return view('admin.dashboard', $data);
    }
}
