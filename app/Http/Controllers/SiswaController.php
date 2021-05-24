<?php

namespace App\Http\Controllers;

use App\User;
use App\Mapel;
use App\Siswa;
use PDF;
use Illuminate\Support\Str;
use App\Exports\SiswaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $matapelajaran = Mapel::all();

        // Menyiapkan data untuk chart
        $categories = [];
        $data = [];

        foreach($matapelajaran as $mp) {
            if($siswa->mapel()->wherePivot('mapel_id', $mp->id)->first()) {
                $categories[] = $mp->nama;
                $data[] = $siswa->mapel()->wherePivot('mapel_id', $mp->id)->first()->pivot->nilai;
            }
        }

        return view('siswa.profile', ['siswa' => $siswa, 'matapelajaran' => $matapelajaran, 'categories' => $categories, 'data' => $data]);
    }

    public function addnilai(Request $request, $id) {
        $siswa = Siswa::find($id);
        if($siswa->mapel()->where('mapel_id', $request->mapel)->exists()) {
            return redirect()->route('siswa.profile', $siswa->id)->with('error', 'Data mata pelajaran sudah ada');
        }
        $siswa->mapel()->attach($request->mapel, ['nilai' => $request->nilai]);
        return redirect()->route('siswa.profile', $siswa->id)->with('sukses', 'Data nilai berhasil dimasukkan');
    }

    public function deletenilai($idsiswa, $idmapel)
    {
        $siswa = Siswa::find($idsiswa);
        $siswa->mapel()->detach($idmapel);
        return redirect()->back()->with('sukses', 'Data nilai berhasil dihapus');
    }

    public function exportExcel() 
    {
        return Excel::download(new SiswaExport, 'Siswa.xlsx');
    }

    public function exportPdf()
    {
        $siswa = Siswa::all();
        $pdf = PDF::loadView('export.siswapdf', ['siswa' => $siswa]);
        return $pdf->download('siswa.pdf');
    }

}
