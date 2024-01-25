<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kitab;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class KitabController extends Controller
{
    public function kitab()
    {
        return view('admin.kitab.index');
    }

    public function tokoKitab()
    {
        $kitab = Kitab::orderBy('id_kitab', 'desc')->get();

        return datatables()
            ->of($kitab)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kitab) {
                return '
                   <a href="/admin/kitab/edit/' . $kitab->id_kitab . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> Edit</a>
                    <button onclick="modalHapus(`' . route('admin.hapusKitab', $kitab->id_kitab) . '`)"  class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tambahKitab()
    {
        return view('admin.kitab.create');
    }

    public function simpanKitab(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama kitab tidak boleh kosong',
        ]);

        DB::beginTransaction();
        try {
            Kitab::insert([
                'nama' => $request->nama,
            ]);
            DB::commit();
            Toastr::success('Data Kitab berhasil disimpan', 'Sukses');
            return redirect(route('admin.kitab'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Data Kitab gagal disimpan', 'Gagal');
            return back()->withInput();
        }
    }

    public function editKitab($id)
    {
        $kitab = Kitab::find($id);
        return view('admin.kitab.edit', compact('kitab'));
    }

    public function updateKitab(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
        ]);

        DB::beginTransaction();
        try {
            Kitab::where('id_kitab', $id)
                ->update([
                    'nama' => $request->nama,
                ]);
            DB::commit();
            Toastr::success('Data Kitab berhasil diupdate', 'Sukses');
            return redirect(route('admin.kitab'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Data Kitab gagal diupdate', 'Gagal');
            return back()->withInput();
        }
    }

    public function hapusKitab($id)
    {
        DB::beginTransaction();
        try {
            $kitab = Kitab::where('id_kitab', $id)->delete();
            DB::commit();
            Toastr::success('Data Kitab berhasil dihapus', 'Sukses');
            if (!$kitab) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Data Kitab gagal dihapus', 'Gagal');
            return back()->withInput();
        }
    }
}


