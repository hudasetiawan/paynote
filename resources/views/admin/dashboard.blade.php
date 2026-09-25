@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
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

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pengguna
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $total_users }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Kategori Pemasukan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalCategoriesIncomes }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tags fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Total Kategori Pengeluaran
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalCategoriesExpenses }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tags fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Transaksi per Kategori Pemasukan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="incomeCategoriesUsedChart"></canvas>
                    </div>
                </div>
            </div>
    
            <div class="col-md-6 col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Transaksi per Kategori Pengeluaran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="expenseCategoriesUsedChart"></canvas>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const categoriesIncomesUsed = @json($totalCategoriesIncomesUsed);

            const categoryNames = categoriesIncomesUsed.map(category => category.name_category);
            const totalUsed = categoriesIncomesUsed.map(category => category.total_used);

            const ctx = document.getElementById('incomeCategoriesUsedChart').getContext('2d');
            const incomeCategoriesUsedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: categoryNames,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: totalUsed,
                        backgroundColor: 'rgb(28,200,138, 0.2)',
                        borderColor: 'rgb(28,200,138)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const categoriesExpensesUsed = @json($totalCategoriesExpensesUsed);

            const categoryNames = categoriesExpensesUsed.map(category => category.name_category);
            const totalUsed = categoriesExpensesUsed.map(category => category.total_used);

            const ctx = document.getElementById('expenseCategoriesUsedChart').getContext('2d');
            const expenseCategoriesUsedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: categoryNames,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: totalUsed,
                        backgroundColor: 'rgb(255, 0, 0, 0.2)',
                        borderColor: 'rgb(255, 0, 0)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
