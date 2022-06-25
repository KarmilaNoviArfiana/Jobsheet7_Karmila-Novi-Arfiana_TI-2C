<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
    * Display a listing of the resource.
    **
    @return \Illuminate\Http\Response
    */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
        
        /*$mahasiswa = $mahasiswa = DB::table('mahasiswa')->paginate(3); // Mengambil semua isi tabel
        $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
        return view('mahasiswa.index', compact('mahasiswa'));
        with('i', (request()->input('page', 1) - 1) * 5);*/
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $paginate = Mahasiswa::where('nama', 'like', "%" . $keyword . "%")->paginate(3);
            return view('mahasiswa.index', compact('paginate'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }
    public function store(Request $request)
    {
    //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tgl_Lahir' => 'required',
        ]);

        $image_name = '';
        if($request->file('photo')){
            $image_name = $request->file('photo')->store('images', 'public');
        }
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tgl_lahir = $request->get('Tgl_Lahir');
        $mahasiswa->photo = $image_name;
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
            return view('mahasiswa.detail', ['Mahasiswa' => $Mahasiswa]);
    }

    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all();
            return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
    }

    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tgl_Lahir' => 'required',
        ]);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        if($mahasiswa->photo && file_exists(storage_path('app/public/' .$mahasiswa->photo))){
            Storage::delete('public/' .$mahasiswa->photo);
        }
        $image_name = $request->file('photo')->store('images', 'public');
        //$mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tgl_lahir = $request->get('Tgl_Lahir');
        $mahasiswa->photo = $image_name;

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        
        //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    public function destroy($Nim)
    {
    //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
            return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($id)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiswa', $id)->first();
        $matkul = Mahasiswa_MataKuliah::with('matakuliah')->where('mahasiswa_id', $id)->get();
            return view('mahasiswa.nilai', compact('Mahasiswa', 'matkul'));
    }

    public function cetak_pdf($id)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiswa', $id)->first();
        $matkul = Mahasiswa_MataKuliah::with('matakuliah')->where('mahasiswa_id', $id)->get();
        $pdf = PDF::loadview('mahasiswa.mahasiswa_pdf', ['Mahasiswa' => $Mahasiswa, 'matakuliah' => $matkul]);
            return $pdf->stream();
    }
};