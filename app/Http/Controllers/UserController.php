<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_id_user(Request $request)
    {
        $id_user = $request->Session()->get('id_user');
        $user = DB::table('tk_4.tb_user')
            ->select('tb_user.first_name', 'tb_user.last_name', 'tb_user.id_user', 'tb_user.id_acces', 'tb_acces.acces_name')
            ->join('tk_4.tb_acces', 'tb_acces.id_acces', 'tb_user.id_acces')
            ->where('id_user', $id_user)
            ->first();
        return $user;
    }

    public function user(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $user = [
                'user' => $this->get_id_user($request),
            ];

            $acces = DB::table('tk_4.tb_acces')
                ->where('acces_softdel', 0)
                ->get();

            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            $search = $request->search;

            $data = DB::table('tk_4.tb_user')
                ->select('tb_user.*', 'tb_acces.acces_name')
                ->join('tk_4.tb_acces', 'tb_acces.id_acces', 'tb_user.id_acces')
                ->where('user_softdel', 0);

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`first_name`,' ',`last_name`)"), 'like', '%' . $search . '%');
            }

            if ($request->order_name == '') {
                $order_name = 'id_user';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Master.user', $user, [
                'title' => 'User',
                'acces' => $acces,
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_user(Request $request)
    {
        $data = new User();
        $data->username = $request->username;
        $data->password = $request->password;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->phone_number = $request->phone_number;
        $data->address = $request->address;
        $data->id_acces = $request->id_acces;
        $data->user_inserted_at = date('Y-m-d H:i:s');
        $data->user_last_updated = date('Y-m-d H:i:s');
        $data->user_softdel = 0;

        $data->save();
        if ($data) {
            \Session::put('success', 'Add New User Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New User Failed!');
            return redirect()->back();
        }
    }

    public function edit_user(Request $request)
    {
        $data = User::find($request->id_user);
        $data->username = $request->edit_username;
        $data->password = $request->edit_password;
        $data->first_name = $request->edit_first_name;
        $data->last_name = $request->edit_last_name;
        $data->phone_number = $request->edit_phone_number;
        $data->address = $request->edit_address;
        $data->id_acces = $request->edit_id_acces;
        $data->user_last_updated = date('Y-m-d H:i:s');

        $data->save();
        if ($data) {
            \Session::put('success', 'Update User Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update User Failed!');
            return redirect()->back();
        }
    }

    public function delete_user(Request $request)
    {
        $data = User::find($request->id_user_delete);
        $data->user_softdel = 1;

        $data->save();
        if ($data) {
            \Session::put('success', 'Delete User Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete User Failed!');
            return redirect()->back();
        }
    }

    public function detail_user($id)
    {
        $data = User::find($id);

        return response()->json([
            'status' => 200,
            'user' => $data,
        ]);
    }
}
