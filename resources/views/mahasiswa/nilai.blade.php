@extends('mahasiswa.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="justify-content-center align-items-center">
                <div class="d-flex justify-content-center mt-2">
                    <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
                </div>
                <div class="d-flex justify-content-center my-4">
                    <h1 class="text-center">KARTU HASIL STUDI (KHS)</h1>
                </div>
            </div>
        </div>
        <div class="text-left">
            <p><b>Nama : </b>{{ $Mahasiswa->nama }}</p>
            <p><b>Nama : </b>{{ $Mahasiswa->nim }}</p>
            <p><b>Nama : </b>{{ $Mahasiswa->kelas->nama_kelas }}</p>
        </div>
        <div class="col d-flex justify-content-end">
            <div style="margin:0px 0px 0px 70px;">
                <a class="btn btn-success" href="{{ route('cetak_pdf', $Mahasiswa->id_mahasiswa) }}">Cetak KHS</a>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Nilai</th>
            </tr>
            @foreach ($matkul as $mk)
                <tr>
                    <td>{{ $mk->matakuliah->nama_matkul }}</td>
                    <td>{{ $mk->matakuliah->sks }}</td>
                    <td>{{ $mk->matakuliah->semester }}</td>
                    <td>{{ $mk->nilai }}</td>
                </tr>
            @endforeach
        </table>
        <a class="btn btn-success" href="{{ route('mahasiswa.index') }}">Kembali</a>
    </div>
@endsection