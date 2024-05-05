<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
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

    public function purchase(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $user = [
                'user' => $this->get_id_user($request),
            ];

            $sortir = 10;
            if ($request->sortir) {
                $sortir = $request->sortir;
            }
            $list_item = DB::table('tk_4.tb_item')
                ->where('item_softdel', 0)
                ->get();

            $search = $request->search;

            $data = DB::table('tk_4.tb_purchase')
                ->select('tb_purchase.*', 'tb_item.item_name', 'tb_user.first_name', 'tb_user.last_name',)
                ->join('tk_4.tb_item', 'tb_item.id_item', 'tb_purchase.id_item')
                ->join('tk_4.tb_user', 'tb_user.id_user', 'tb_purchase.id_user')
                ->where('purchase_softdel', 0);

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`item_name`)"), 'like', '%' . $search . '%');
            }

            if ($request->order_name == '') {
                $order_name = 'id_purchase';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Purchase.purchase', $user, [
                'title' => 'Purchase',
                'list_item' => $list_item,
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_purchase(Request $request)
    {
        $data = new Purchase();
        $data->purchase_amount = $request->purchase_amount;
        $data->purchase_price = str_replace('.', '', $request->purchase_price);
        $data->id_user = $request->Session()->get('id_user');
        $data->id_item = $request->id_item;
        $data->purchase_inserted_at = date('Y-m-d H:i:s');
        $data->purchase_softdel = 0;
        $item = Item::find($request->id_item);
        $item->unit = $item->unit + $request->purchase_amount;

        $item->save();
        $data->save();

        if ($data) {
            \Session::put('success', 'Add New Purchase Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Purchase Failed!');
            return redirect()->back();
        }
    }
}
