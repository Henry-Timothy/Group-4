<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
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
                ->select('tb_transaction.*', 'tb_customer.customer_name', 'tb_user.first_name')
                ->join('punya_farrel.tb_customer', 'tb_customer.id_customer', 'tb_transaction.id_customer')
                ->join('punya_farrel.tb_user', 'tb_user.id_user', 'tb_transaction.transaction_inserted_by');

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

            return view('Master.transaction', $user, [
                'title' => 'Transaction',
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function detail_trans_by_id($id)
    {

        $detail_col = DB::table('tb_detail_transaction')
            ->join('tb_transaction', 'tb_transaction.id_transaction', '=', 'tb_detail_transaction.id_transaction')
            ->join('tb_item', 'tb_item.id_item', '=', 'tb_detail_transaction.id_item')
            ->where('tb_detail_transaction.id_transaction', $id)
            ->get();

        return response()->json($detail_col);
    }

    public function page_add_transaction(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $user = [
                'user' => $this->get_id_user($request),
            ];

            $item = DB::table('tb_item')->where('item_softdel', 0)->get();
            $customer = DB::table('tb_customer')->get();

            $detail_trans = DB::table('tb_detail_transaction')
            ->join('tb_item', 'tb_item.id_item', '=', 'tb_detail_transaction.id_item')
            ->where('id_transaction', 0)
            ->where('detail_transaction_softdel', 0)
            ->get();

            return view('Master.add_transaction', $user, [
                'title' => 'Add Transaction',
                'item' => $item,
                'customer' => $customer,
                'detail_trans' => $detail_trans
            ]);
        } else {
            return redirect('/');
        }
    }

    public function get_item($id)
    {

        $get = DB::table('tb_item')->where('id_item', $id)->first();

        return response()->json($get);
    }

    public function add_transaction(Request $request)
    {
        $data = new TransactionDetail();
        $data->id_item = $request->id_item;
        $data->qty = $request->qty;
        $data->price = $request->price;
        $data->total_price = $request->total_price;
        $data->id_transaction = 0;
        $data->detail_transaction_softdel = 0;

        $item = Item::find($request->id_item);
        $item->unit = $item->unit  - $request->qty;

        $item->save();
        $data->save();


        if ($data) {
            \Session::put('success', 'Add New Acces Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Acces Failed!');
            return redirect()->back();
        }
    }

    public function delete_transaction_detail(Request $request, $id)
    {
        // $data = TransactionDetail::find($id);
        // $data->detail_transaction_softdel = 1;

        // $data->save();
        // if ($data) {
        //     return redirect()->back();
        // }

        $data = TransactionDetail::find($id);
        $data->detail_transaction_softdel = 1;
        $data->save();

        return response()->json([
            'id' =>  $id
        ]);
    }

    public function add_trans(Request $request)
    {
        $a = DB::table('tb_detail_transaction')
        ->join('tb_item', 'tb_item.id_item', '=', 'tb_detail_transaction.id_item')
        ->where('id_transaction', 0)
        ->where('detail_transaction_softdel', 0);

        $data = new Transaction();
        $data->id_customer = $request->id_customer;
        $data->total_amount = $a->sum('total_price');
        $data->transaction_inserted_at = date('Y-m-d H:i:s');
        $data->transaction_inserted_by =$request->Session()->get('id_user');

        $data->save();


        $detail_trans = $a->get();
        foreach($detail_trans as $det){
            $data_detail = TransactionDetail::find($det->id_detail_transaction);
            $data_detail->id_transaction = $data->id_transaction;
            $data_detail->save();
        }
        if ($data) {
            \Session::put('success', 'Add New Acces Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Acces Failed!');
            return redirect()->back();
        }
    }


}
