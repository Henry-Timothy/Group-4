<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemController extends Controller
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

    public function item(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $user = [
                'user' => $this->get_id_user($request),
            ];

            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            $supplier = DB::table('tk_4.tb_supplier')
                ->where('supplier_softdel', 0)
                ->get();

            $search = $request->search;

            $data = DB::table('tk_4.tb_item')
                ->select('tb_item.*', 'tb_supplier.supplier_name')
                ->leftJoin('tk_4.tb_supplier', 'tb_supplier.id_supplier', 'tb_item.id_supplier')
                ->where('item_softdel', 0);

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`item_name`,' ',`description`)"), 'like', '%' . $search . '%');
            }

            if ($request->id_supplier) {
                $data->where('id_supplier', $request->id_supplier);
            }

            if ($request->order_name == '') {
                $order_name = 'id_item';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Master.item', $user, [
                'title' => 'Item',
                'supplier' => $supplier,
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_item(Request $request)
    {
        $data = new Item();
        $data->item_name = $request->item_name;
        $data->description = $request->description;
        // $data->unit = $request->unit;
        $data->price = str_replace('.', '', $request->price);
        $data->id_supplier = $request->id_supplier;
        $data->item_inserted_at = date('Y-m-d H:i:s');
        $data->item_last_updated = date('Y-m-d H:i:s');
        $data->item_softdel = 0;

        $data->save();
        if ($data) {
            \Session::put('success', 'Add New Item Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Item Failed!');
            return redirect()->back();
        }
    }

    public function edit_item(Request $request)
    {
        $data = Item::find($request->id_item);
        $data->item_name = $request->edit_item_name;
        $data->description = $request->edit_description;
        // $data->unit = $request->edit_unit;
        $data->price = str_replace('.', '', $request->edit_price);
        $data->id_supplier = $request->edit_id_supplier;
        $data->item_last_updated = date('Y-m-d H:i:s');

        $data->save();
        if ($data) {
            \Session::put('success', 'Update Item Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update Item Failed!');
            return redirect()->back();
        }
    }

    public function delete_item(Request $request)
    {
        $data = Item::find($request->id_item_delete);
        $data->item_softdel = 1;

        $data->save();
        if ($data) {
            \Session::put('success', 'Delete Item Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete Item Failed!');
            return redirect()->back();
        }
    }

    public function get_id_item($id)
    {
        $data = Item::find($id);

        return response()->json([
            'status' => 200,
            'item' => $data,
        ]);
    }
}
