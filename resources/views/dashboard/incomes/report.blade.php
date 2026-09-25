<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemasukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Laporan Pemasukan</h1>
    <p>Periode: {{ $formattedPeriods }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomes as $income)
                <tr>
                    <td>{{ $income->date }}</td>
                    <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                    <td>
                        @foreach ($categories as $category)
                            @if ($category->id_category == $income->id_category)
                                {{ $category->name_category }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $income->description }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="total">Total Pemasukan</td>
                <td class="total">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>