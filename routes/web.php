<?php

use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomesController;

// Home Route
Route::view('/', 'home.index')->name('home');

// Auth Routes
Route::group(['middleware' => 'web'], function () {
    Route::get('/login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Auth\LoginController::class, 'login']);
    Route::get('/register', [Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [Auth\RegisterController::class, 'register']);
    Route::post('/logout', [Auth\LoginController::class, 'logout'])->name('logout');
});

// Kategori
Route::group(['middleware' => ['auth']], function () {
    Route::get('categories', [CategoriesController::class, 'index'])->name('categories');
    Route::get('categories/add', [CategoriesController::class, 'addPage'])->name('categories.addPage');
    Route::post('categories/insert', [CategoriesController::class, 'insert'])->name('categories.insert');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'editPage'])->name('categories.editPage');
    Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoriesController::class, 'delete'])->name('categories.delete');
});

// Kategori Pemasukan (Income Categories)
Route::group(['middleware' => ['auth']], function () {
    Route::get('categories/income', [CategoriesController::class, 'incomeCategories'])->name('categories.income');
    Route::get('categories/expense', [CategoriesController::class, 'expenseCategories'])->name('categories.expense');
});

// Incomes
Route::middleware(['auth'])->group(function () {
    Route::get('incomes', [IncomesController::class, 'index'])->name('incomes');
    Route::get('incomes/add', [IncomesController::class, 'addPage'])->name('incomes.addPage');
    Route::post('incomes/insert', [IncomesController::class, 'insert'])->name('incomes.insert');
    Route::get('incomes/edit/{id}', [IncomesController::class, 'editPage'])->name('incomes.editPage');
    Route::put('incomes/update/{id}', [IncomesController::class, 'update'])->name('incomes.update');
    Route::get('incomes/delete/{id}', [IncomesController::class, 'delete'])->name('incomes.delete');
    Route::get('incomes/export-pdf', [IncomesController::class, 'exportPDF'])->name('incomes.exportPDF');
});

// Expenses
Route::middleware(['auth'])->group(function () {
    Route::get('expenses', [ExpensesController::class, 'index'])->name('expenses');
    Route::get('expenses/add', [ExpensesController::class, 'addPage'])->name('expenses.addPage');
    Route::post('expenses/insert', [ExpensesController::class, 'insert'])->name('expenses.insert');
    Route::get('expenses/edit/{id_expense}', [ExpensesController::class, 'editPage'])->name('expenses.editPage');
    Route::put('expenses/update/{id_expense}', [ExpensesController::class, 'update'])->name('expenses.update');
    Route::delete('expenses/delete/{id_expense}', [ExpensesController::class, 'delete'])->name('expenses.delete');
    Route::get('expenses/export-pdf', [ExpensesController::class, 'exportPDF'])->name('expenses.exportPDF');
});

// Admin Route
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Auth Routes
Auth::routes();

Route::get('chatbot', function () {
    return view('dashboard.bot');
})->name('bot.view');

Route::post('chatbot', [ChatbotController::class, 'bot'])->name('bot.post');