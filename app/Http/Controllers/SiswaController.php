<?php

namespace App\Http\Controllers;

use App\User;
use App\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request) {
        if($request->has('cari')) {
            $data_siswa = Siswa::where('nama_depan', 'LIKE', '%'. $request->cari . '%')->get();
        } else {
            $data_siswa = Siswa::all();
        }
        return view('siswa.index', ['data_siswa' => $data_siswa]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'nama_depan' => 'required|min:5',
            'nama_belakang' => 'required',
            'email' => 'required|email|unique:users',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'avatar' => 'mimes:jpg,png'
        ]);
        // insert ke table users
        $user = new User;
        $user->role ='siswa';
        $user->name = $request->nama_depan;
        $user->email = $request->email;
        $user->password = bcrypt('rahasia');
        $user->remember_token = Str::random(60);
        $user->save();
        
        // insert ke table siswa
        $request->request->add(['user_id' => $user->id]);
        $siswa = Siswa::create($request->all());
        
        if($request->hasFile('avatar')) {
            $request->file('avatar')->move('images/', $request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
        return redirect('/siswa')->with('sukses', 'Data berhasil diinput');
    }

    public function edit($id) {
        $siswa = Siswa::find($id);
        return view('siswa.edit', ['siswa' => $siswa]);
    }

    public function update(Request $request, $id) {
        $siswa = Siswa::find($id);
        $siswa->update($request->all());
        if($request->hasFile('avatar')) {
            $request->file('avatar')->move('images/', $request->file('avatar')->getClientOriginalName());
            $siswa->avatar = $request->file('avatar')->getClientOriginalName();
            $siswa->save();
        }
        return redirect('/siswa')->with('sukses', 'Data berhasil diupdate');
    }

    public function destroy($id) {
        $siswa = Siswa::find($id);
        $siswa->delete($siswa);
        return redirect('/siswa')->with('sukses', 'Data berhasil dihapus');
    }

    public function profile($id) {
        $siswa = Siswa::find($id);
        return view('siswa.profile', ['siswa' => $siswa]);
    }
}
