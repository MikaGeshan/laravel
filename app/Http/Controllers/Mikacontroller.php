<?php

namespace App\Http\Controllers;

use App\Models\mika;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Mikacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)){
            $data = mika::where('nisn','like',"%$katakunci%")
                ->orWhere('nama','like',"%$katakunci%")
                ->orWhere('jurusan','like',"%$katakunci%")
                ->paginate($jumlahbaris);
        }else{
            $data = mika::orderBy('nisn','desc')->paginate($jumlahbaris);
        }
        return view('mika.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mika.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('nisn' ,$request->nisn);
        Session::flash('nama' ,$request->nama);
        Session::flash('jurusan' ,$request->jurusan);

        $request->validate([
            'nisn'=>'required|numeric|unique:mika,nisn',
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nisn.required'=>'NISN wajib diisi',
            'nisn.numeric'=>'NISN wajib dalam angka',
            'nisn.unique'=>'NISN sudah terdaftar',
            'nama.required'=>'Nama wajib diisi',
            'jurusan.required'=>'Jurusan wajib diisi',
        ]);
        $data = [
            'nisn' =>$request->nisn,
            'nama' =>$request->nama,
            'jurusan' =>$request->jurusan,
        ];
        mika::create($data);
        return redirect()->to('mika')->with('success','Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = mika::where('nisn', $id)->first();
        return view('mika.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'jurusan.required'=>'Jurusan wajib diisi',
        ]);
        $data = [
            'nama' =>$request->nama,
            'jurusan' =>$request->jurusan,
        ];
        mika::where('nisn',$id)->update($data);
        return redirect()->to('mika')->with('success','Berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        mika::where('nisn',$id)->delete();
        return redirect()->to('mika')->with('success', 'Berhasil menghapus data');
    }
}
