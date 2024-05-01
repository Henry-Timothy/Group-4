<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HakAkses;
use Illuminate\Support\Facades\DB;


class HakAksesController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_id_user(Request $request)
    {
        $IdPengguna = $request->Session()->get('IdPengguna');
        $user = DB::table('introduction_to_data.tb_pengguna')
            ->select('tb_pengguna.NamaDepan', 'tb_pengguna.NamaBelakang', 'tb_pengguna.IdPengguna', 'tb_pengguna.IdAkses', 'tb_hak_akses.NamaAkses')
            ->join('tb_hak_akses', 'tb_hak_akses.IdAkses', 'tb_pengguna.IdAkses')
            ->where('IdPengguna', $IdPengguna)
            ->first();
        return $user;
    }

    public function akses(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $user = [
                'user' => $this->get_id_user($request),
            ];

            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            $search = $request->search;

            $data = DB::table('introduction_to_data.tb_hak_akses')
                ->select('tb_hak_akses.*');

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`NamaAkses`,' ',`Keterangan`)"), 'like', '%' . $search . '%');
            }

            if ($request->order_name == '') {
                $order_name = 'IdAkses';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Master.akses', $user, [
                'title' => 'Akses',
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }
}
