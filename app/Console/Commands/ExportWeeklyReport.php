<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ExpensesController;

class ExportWeeklyReport extends Command
{
    protected $signature = 'report:weekly';
    protected $description = 'Ekspor laporan pengeluaran mingguan secara otomatis';

    public function handle()
    {
        $controller = new ExpensesController();
        $filePath = $controller->exportWeeklyPDF();

        $this->info('Laporan mingguan berhasil diekspor ke: ' . $filePath);
    }
}
