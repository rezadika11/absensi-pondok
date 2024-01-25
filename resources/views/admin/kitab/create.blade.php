@extends('layouts.main')
@section('title', 'Tambah Kitab')
@section('content')
    <div class="page-heading">
        <h3>@yield('title')</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('admin.simpanKitab') }}" class="form form-horizontal" method="POST">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Nama</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" name="nama" id="first-name-horizontal"
                                            class="form-control @error('nama')
                                        is-invalid
                                      @enderror"
                                            name="nama" placeholder="Masukan Nama Kitab" value="{{ old('nama') }}">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-start mt-4">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"><i class="fas fa-save"></i>
                                            Simpan</button>
                                        <a href="{{ route('admin.kitab') }}" class="btn btn-light-secondary me-1 mb-1"><i
                                                class="fas fa-arrow-right"></i> Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
