<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

class SupplierController extends Controller
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

    public function supplier(Request $request)
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

            $data = DB::table('tk_4.tb_supplier')
                ->select('tb_supplier.*')
                ->where('supplier_softdel', 0);

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`supplier_name`,' ',`supplier_phone`,' ',`supplier_address`)"), 'like', '%' . $search . '%');
            }

            if ($request->order_name == '') {
                $order_name = 'id_supplier';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Master.supplier', $user, [
                'title' => 'Supplier',
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_supplier(Request $request)
    {
        $data = new Supplier();
        $data->supplier_name = $request->supplier_name;
        $data->supplier_address = $request->supplier_address;
        $data->supplier_phone = $request->supplier_phone;
        $data->supplier_inserted_at = date('Y-m-d H:i:s');
        $data->supplier_last_updated = date('Y-m-d H:i:s');
        $data->supplier_softdel = 0;

        $data->save();
        if ($data) {
            \Session::put('success', 'Add New Supplier Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Supplier Failed!');
            return redirect()->back();
        }
    }

    public function edit_Supplier(Request $request)
    {
        $data = Supplier::find($request->id_supplier);
        $data->supplier_name = $request->edit_supplier_name;
        $data->supplier_address = $request->edit_supplier_address;
        $data->supplier_phone = $request->edit_supplier_phone;
        $data->supplier_last_updated = date('Y-m-d H:i:s');

        $data->save();
        if ($data) {
            \Session::put('success', 'Update Supplier Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update Supplier Failed!');
            return redirect()->back();
        }
    }

    public function delete_supplier(Request $request)
    {
        $data = Supplier::find($request->id_supplier_delete);
        $data->supplier_softdel = 1;

        $data->save();
        if ($data) {
            \Session::put('success', 'Delete Supplier Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete Supplier Failed!');
            return redirect()->back();
        }
    }

    public function get_id_supplier($id)
    {
        $data = Supplier::find($id);

        return response()->json([
            'status' => 200,
            'supplier' => $data,
        ]);
    }
}
