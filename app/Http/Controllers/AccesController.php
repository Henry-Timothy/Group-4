<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Acces;


class AccesController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_id_user(Request $request)
    {
        $id_user = $request->Session()->get('id_user');
        $user = DB::table('punya_farrel.tb_user')
            ->select('tb_user.first_name', 'tb_user.last_name', 'tb_user.id_user', 'tb_user.id_acces', 'tb_acces.acces_name')
            ->join('punya_farrel.tb_acces', 'tb_acces.id_acces', 'tb_user.id_acces')
            ->where('id_user', $id_user)
            ->first();
        return $user;
    }

    public function acces(Request $request)
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

            $data = DB::table('punya_farrel.tb_acces')
                ->select('tb_acces.*')
                ->where('acces_softdel', 0);

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`acces_name`)"), 'like', '%' . $search . '%');
            }

            if ($request->order_name == '') {
                $order_name = 'id_acces';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Master.acces', $user, [
                'title' => 'Acces',
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_acces(Request $request)
    {
        $data = new Acces;
        $data->acces_name = $request->acces_name;
        $data->acces_inserted_at = date('Y-m-d H:i:s');
        $data->acces_last_updated = date('Y-m-d H:i:s');
        $data->acces_softdel = 0;

        $data->save();
        if ($data) {
            \Session::put('success', 'Add New Acces Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Acces Failed!');
            return redirect()->back();
        }
    }

    public function edit_acces(Request $request)
    {
        $data = Acces::find($request->id_acces);
        $data->acces_name = $request->edit_acces_name;
        $data->acces_last_updated = date('Y-m-d H:i:s');

        $data->save();
        if ($data) {
            \Session::put('success', 'Update Acces Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update Acces Failed!');
            return redirect()->back();
        }
    }

    public function delete_acces(Request $request)
    {
        $data = Acces::find($request->id_acces_delete);
        $data->acces_softdel = 1;

        $data->save();
        if ($data) {
            \Session::put('success', 'Delete Acces Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete Acces Failed!');
            return redirect()->back();
        }
    }

    public function get_id_acces($id)
    {
        $data = Acces::find($id);

        return response()->json([
            'status' => 200,
            'acces' => $data,
        ]);
    }
}
