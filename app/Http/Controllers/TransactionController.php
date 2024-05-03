<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HakAkses;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function transaction(Request $request)
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

            $data = DB::table('tb_transaction')
                ->select('tb_transaction.*');

            // if ($request->search) {
            //     $data->where(DB::raw("CONCAT(`NamaAkses`,' ',`Keterangan`)"), 'like', '%' . $search . '%');
            // }

            if ($request->order_name == '') {
                $order_name = 'id_transaction';
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
