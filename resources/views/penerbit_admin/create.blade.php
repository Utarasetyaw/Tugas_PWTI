@extends('layouts.partials.app')

@section('title')
    Tambah Penerbit
@endsection

@section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="main-content" style="min-height: 116px;">
            <section class="section">
                <div class="section-header">
                    <h1>Tambah Penerbit</h1>
                </div>
                <div class="section-body">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tambah Penerbit</h4>
                        </div>
                                <div class="card-body">
                                    <form action="{{ route('penerbit.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate="" >
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Nama
                                                    <input type="text" class="form-control" required id="nama" name="nama" value="{{ old('nama') }}">
                                                    @error('nama')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <br/>

                                                    Email
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                                    <br/>

                                                    Telepon
                                                    <input type="number" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    Alamat
                                                    <textarea type="text" class="form-control" name="alamat" value="{{ old('alamat') }}" style="height:215px"></textarea>
                                                </div>
                                            </div>
                                            </div>
                                        
                                        <button class="btn btn-primary" type="submit">Simpan Data</button>
                                    </form>
                                </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
