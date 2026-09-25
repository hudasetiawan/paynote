@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">
        <div class="row">
            <div class="table-responsive shadow-sm p-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('expenses.addPage') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-plus"></i>
                            Tambah Data Pengeluaran
                        </a>
                        <a href="{{ route('expenses.exportPDF') }}" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->date }}</td>
                                <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                <td>
                                    @foreach ($categories as $category)
                                        @if ($category->id_category == $expense->id_category)
                                            <span
                                                class="badge badge-pill badge-primary py-2">{{ $category->name_category }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $expense->description }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('expenses.editPage', $expense->id_expense) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <!-- Delete Button (trigger Modal) -->
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#deleteexpenseModal{{ $expense->id_expense }}">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach ($expenses as $expense)
                <div class="modal fade" id="deleteexpenseModal{{ $expense->id_expense }}" tabindex="-1"
                    aria-labelledby="deleteexpenseModal{{ $expense->id_expense }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteexpenseModal{{ $expense->id_expense }}">Hapus Data
                                    Pengeluaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus pengeluaran {{ $expense->description }}?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <form action="{{ route('expenses.delete', $expense->id_expense) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
