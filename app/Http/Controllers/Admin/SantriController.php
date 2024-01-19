<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SantriController extends Controller
{
    public function santri()
    {
        return view('admin.santri.index');
    }

    public function dataSantri()
    {
        $santri = Santri::orderBy('id_santri', 'desc')->get();

        return datatables()
            ->of($santri)
            ->addIndexColumn()
            ->addColumn('aksi', function ($santri) {
                return '
                   <a href="/admin/santri/edit/' . $santri->id_santri . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> Edit</a>
                    <button onclick="modalHapus(`' . route('admin.hapusSantri', $santri->id_santri) . '`)"  class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambahSantri()
    {
        return view('admin.santri.create');
    }

    public function simpanSantri(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required|unique:santri,nis',
            'nama' => 'required',
        ], [
            'nis.required' => 'NIS tidak boleh kosong',
            'nis.unique' => 'NIS sudah ada, mohon ganti yang lain',
            'nama.required' => 'Nama tidak boleh kosong',
        ]);

        DB::beginTransaction();
        try {
            Santri::insert([
                'nis' => $request->nis,
                'nama' => $request->nama,
            ]);
            DB::commit();
            Toastr::success('Data Santri berhasil disimpan', 'Sukses');
            return redirect(route('admin.santri'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Data Santri gagal disimpan', 'Gagal');
            return back()->withInput();
        }
    }

    public function editSantri($id)
    {
        $santri = Santri::find($id);
        return view('admin.santri.edit', compact('santri'));
    }

    public function updateSantri(Request $request, $id)
    {
        $data = $request->validate([
            'nis' => ['required', Rule::unique('santri', 'nis')->ignore($id, 'id_santri')],
            'nama' => 'required',
        ], [
            'nis.required' => 'NIS tidak boleh kosong',
            'nis.unique' => 'NIS sudah ada, mohon ganti yang lain',
            'nama.required' => 'Nama tidak boleh kosong',
        ]);

        DB::beginTransaction();
        try {
            Santri::where('id_santri', $id)
                ->update([
                    'nis' => $request->nis,
                    'nama' => $request->nama,
                ]);
            DB::commit();
            Toastr::success('Data Santri berhasil diupdate', 'Sukses');
            return redirect(route('admin.santri'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Data Santri gagal diupdate', 'Gagal');
            return back()->withInput();
        }
    }

    public function hapusSantri($id)
    {
        DB::beginTransaction();
        try {
            $santri = Santri::where('id_santri', $id)->delete();
            DB::commit();
            Toastr::success('Data Santri berhasil dihapus', 'Sukses');
            if (!$santri) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Data Santri gagal dihapus', 'Gagal');
            return back()->withInput();
        }
    }
}
