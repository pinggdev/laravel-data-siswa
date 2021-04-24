@extends('layouts.master')
@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit Siswa</h3>
                            </div>
                            <div class="panel-body">
                                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Depan</label>
                                        <input name="nama_depan" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $siswa->nama_depan }}">
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Belakang</label>
                                        <input name="nama_belakang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $siswa->nama_belakang }}">
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Pilih Jenis Kelamin</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="jenis_kelamin">
                                            <option value="L" @if ($siswa->jenis_kelamin == 'L') selected @endif>Laki-Laki</option>
                                            <option value="P" @if ($siswa->jenis_kelamin == 'P') selected @endif>Perempuan</option>
                                        </select>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Agama</label>
                                        <input name="agama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $siswa->agama }}">
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Alamat</label>
                                        <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $siswa->alamat }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Avatar</label>
                                        <input type="file" name="avatar" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection