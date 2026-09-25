@extends('layouts.app')

@section('content')
<div class="container-fluid px-5">
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow-sm p-3">
        <div class="card-header">
          <h5 class="card-title fw-bold">
            Edit Data Pemasukan
          </h5>
        </div>
        <div class="card-body">
          <!-- Form -->
          <form action="{{ route('incomes.update', $income->id_income) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="form-group">
                <label for="id_category">Kategori</label>
                <select class="form-control @error('id_category') is-invalid @enderror" id="id_category" name="id_category">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id_category }}" {{ $income->id_category == $category->id_category ? 'selected' : '' }}>
                            {{ $category->name_category }}
                        </option>
                    @endforeach
                </select>
                @error('id_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="form-group">
                <label for="amount">Jumlah</label>
                <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ $income->amount }}">
                @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $income->description }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="form-group">
                <label for="date">Tanggal</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $income->date }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-sm btn-success">Perbarui</button>
            <a href="{{ route('incomes') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </form>        
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
