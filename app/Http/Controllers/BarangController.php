<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    // public function get_id_user(Request $request)
    // {
    //     $IdPengguna = $request->Session()->get('IdPengguna');
    //     $user = DB::table('introduction_to_data.tb_pengguna')
    //         ->select('tb_pengguna.NamaDepan', 'tb_pengguna.NamaBelakang', 'tb_pengguna.IdPengguna', 'tb_pengguna.IdAkses', 'tb_hak_akses.NamaAkses')
    //         ->join('tb_hak_akses', 'tb_hak_akses.IdAkses', 'tb_pengguna.IdAkses')
    //         ->where('IdPengguna', $IdPengguna)
    //         ->first();
    //     return $user;
    // }

    public function barang(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $data = [
                'user' => $this->get_id_user($request),
            ];

            return view('Master.barang', $data, [
                'title' => 'Barang',
            ]);
        } else {
            return redirect('/');
        }
    }
}
