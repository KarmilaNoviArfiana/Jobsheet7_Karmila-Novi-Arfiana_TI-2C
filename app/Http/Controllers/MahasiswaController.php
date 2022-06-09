<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $mahasiswa = Mahasiswa::with('kelas')->latest('nim')->paginate(3);
        return view('mahasiswa.index', compact('mahasiswa'));
 
       // return view('mahasiswa.index', [
            //'mahasiswa' => DB::table('mahasiswa')->paginate(3)
        //]);
        
        //$mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel
        //$posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        //return view('mahasiswa.index', compact('mahasiswa'));
        //with('i', (request()->input('page', 1) - 1) * 5);

        //$mahasiswa = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
        //$paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        //return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' =>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'TL' => 'required',
            ]);

            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $request->get('Nim');
            $mahasiswa->nama = $request->get('Nama');
            $mahasiswa->jurusan = $request->get('Jurusan');
            $mahasiswa->email = $request->get('Email');
            $mahasiswa->alamat = $request->get('Alamat');
            $mahasiswa->tl = $request->get('TL');
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');

            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            //Mahasiswa::create($request->all());
            return redirect()->route('mahasiswa.index')
                    ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        $Mahasiswa = Mahasiswa::where('nim',$Nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswa.edit', compact('Mahasiswa'));
        /*$Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();;
        return view('mahasiswa.edit', compact('Mahasiswa'));*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'TL' => 'required',
            ]);

            $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first()->update($request->all());
            //Mahasiswa::where('nim', $nim)->first()->update($request->all());
            return view('mahasiswa.edit', compact('Mahasiswa'));
            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        Mahasiswa::where('nim',$Nim)->first()->delete();
        return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $mahasiswa = Mahasiswa::where('nama', 'like', '%' . $search . '%')->simplePaginate(3);
        return view('mahasiswa.index', compact('mahasiswa'));
    }
}