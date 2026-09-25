@extends('layouts.app')

@section('content')
    <style>
        .toast {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1050;
        }
    </style>
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="alert border-left-secondary shadow alert-warning alert-dismissible fade shadow show"
                    role="alert">
                    <strong>Selamat Datang!</strong> Anda telah masuk sebagai <strong>{{ Auth::user()->name }}</strong>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Balance Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Saldo
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($total_balance, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Income Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pemasukan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($total_incomes, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-down fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pengeluaran
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ number_format($total_expenses, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-up fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low balancing --}}
        @if ($lowBalanceWarning)
            <div class="toast" id="lowBalanceToast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="false">
                <div class="toast-header">
                    <strong class="me-auto text-danger">Peringatan Saldo</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ $lowBalanceWarning }}
                </div>
            </div>
        @endif

        {{-- Grafik pemasukan & pengurangan --}}
        <div class="row mt-4 mb-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="font-weight-bold text-secondary">Grafik Kenaikan Pemasukan (Mingguan)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="incomeChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="font-weight-bold text-secondary">Grafik Kenaikan Pengeluaran (Mingguan)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="expenseChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table ( Income, Expanse ) Content -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="table">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-secondary">Pemasukan & Pengeluaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Jenis Transaksi</th>
                                            <th>Jumlah</th>
                                            <th>Deskripsi</th>
                                            <th>Tanggal</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($incomesAndExpenses as $index => $incomeAndExpense)
                                            <tr>
                                                <td>
                                                    @if ($incomeAndExpense instanceof App\Models\Incomes)
                                                        <span class="badge badge-success">Pemasukan</span>
                                                    @elseif($incomeAndExpense instanceof App\Models\Expenses)
                                                        <span class="badge badge-danger">Pengeluaran</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($incomeAndExpense->amount, 0, ',', '.') }}</td>
                                                <td>{{ $incomeAndExpense->description }}</td>
                                                <td>{{ $incomeAndExpense->date }}</td>
                                                <td>
                                                    @foreach ($categories as $category)
                                                        @if ($category->id_category == $incomeAndExpense->id_category)
                                                            {{ $category->name_category }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const weeklyIncomes = @json($weeklyIncomes);
        const weeklyExpenses = @json($weeklyExpenses);

        // Extract labels (weeks) and data
        const labelIncome = weeklyIncomes.map(data => `Week ${data.week}`);
        const labelExpense = weeklyExpenses.map(data => `Week ${data.week}`);
        const incomeData = weeklyIncomes.map(data => data.total);
        const expenseData = weeklyExpenses.map(data => data.total);

        // Chart for incomes
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        const incomeChart = new Chart(incomeCtx, {
            type: 'line',
            data: {
                labels: labelIncome,
                datasets: [{
                    label: 'Pemasukan',
                    data: incomeData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Minggu'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah (IDR)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart for expenses
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        const expenseChart = new Chart(expenseCtx, {
            type: 'line',
            data: {
                labels: labelExpense,
                datasets: [{
                    label: 'Pengeluaran',
                    data: expenseData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Minggu'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah (IDR)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var toastElement = document.getElementById('lowBalanceToast');
            var btnClose = document.querySelector('.btn-close');
            if (toastElement) {
                var toast = new bootstrap.Toast(toastElement, {
                    autohide: false // Toast tetap muncul hingga ditutup
                });
                toast.show();
            } else {
                console.log("Toast element not found.");
            }

            btnClose.addEventListener('click', function() {
                toast.hide();
            });
        });
    </script>
@endsection
