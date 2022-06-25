@extends('mahasiswa.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
            </div> 
            <div class="col-md-4">
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group custom-search-form">
	                    <input type="search" name="search" class="form-control" placeholder="Cari Mahasiswa">
                        <span class="input-group-btn"><button type="submit" class="btn btn-primary">Search</button></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th width="50px">Foto</th>
            <th width="300px">Action</th>
        </tr>
        @foreach ($paginate as $mhs)
            <tr>

                <td>{{ $mhs ->nim }}</td>
                <td>{{ $mhs ->nama }}</td>
                <td>{{ $mhs ->kelas->nama_kelas }}</td>
                <td>{{ $mhs ->jurusan }}</td>
                <td>{{ $mhs ->email }}</td>
                <td>{{ $mhs ->alamat }}</td>
                <td>{{ $mhs ->tgl_lahir }}</td>
                <td><img width="50px" class="img-circle" src="{{ asset('storage/' . $mhs->photo) }}" ></td>
                <td>
                <form action="{{ route('mahasiswa.destroy',['mahasiswa'=>$mhs->nim]) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('mahasiswa.show',$mhs->nim) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$mhs->nim) }}">Edit</a>
                    
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a class="btn btn-warning" href="{{ route('mahasiswa.nilai',$mhs->id_mahasiswa) }}">Nilai</a>
                </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $paginate->links('pagination::bootstrap-4') }}
@endsection