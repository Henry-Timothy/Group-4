<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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

    public function dashboard(Request $request)
    {
        if ($request->Session()->get('logged_in') == true) {

            $data = [
                'user' => $this->get_id_user($request),
            ];

            $data_item = DB::table('tb_item')
                ->join('tb_detail_transaction', 'tb_detail_transaction.id_item', '=', 'tb_item.id_item')
                ->join('tb_purchase', 'tb_purchase.id_item', '=', 'tb_detail_transaction.id_item')
                ->select(
                    'tb_item.id_item',
                    'tb_item.item_name',
                    DB::raw('SUM(tb_detail_transaction.qty) as selling_qty'),
                    DB::raw('(SELECT price FROM tb_detail_transaction WHERE tb_detail_transaction.id_item = tb_item.id_item LIMIT 1) as selling_price'),
                    DB::raw('SUM(tb_detail_transaction.qty * tb_detail_transaction.price) as total_selling_price'),
                    DB::raw('(SELECT REPLACE(REPLACE(purchase_price, ".", ""), ",", ".") / purchase_amount FROM tb_purchase WHERE tb_purchase.id_item = tb_item.id_item LIMIT 1) * SUM(tb_detail_transaction.qty) as total_purchase_price'),
                    DB::raw('(SUM(tb_detail_transaction.qty * tb_detail_transaction.price) - (SELECT REPLACE(REPLACE(purchase_price, ".", ""), ",", ".") / purchase_amount FROM tb_purchase WHERE tb_purchase.id_item = tb_item.id_item LIMIT 1) * SUM(tb_detail_transaction.qty)) as calculate')
                )
                ->where('tb_detail_transaction.id_transaction', '!=', 0)
                ->where('detail_transaction_softdel', 0)
                ->groupBy('tb_item.id_item', 'tb_item.item_name')
                ->get();

            $total_customer = DB::table('tb_customer')
                ->where('customer_softdel', 0)
                ->count();

            $total_supplier = DB::table('tb_supplier')
                ->where('supplier_softdel', 0)
                ->count();

            return view('Dashboard.dashboard', $data, [
                'data_item' => $data_item,
                'title' => 'Dashboard',
                'total_customer' => $total_customer,
                'total_supplier' => $total_supplier,
            ]);
        } else {
            return redirect('/');
        }
    }
}
