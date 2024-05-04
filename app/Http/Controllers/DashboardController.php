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
        $user = DB::table('punya_farrel.tb_user')
            ->select('tb_user.first_name', 'tb_user.last_name', 'tb_user.id_user', 'tb_user.id_acces', 'tb_acces.acces_name')
            ->join('punya_farrel.tb_acces', 'tb_acces.id_acces', 'tb_user.id_acces')
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

            $total_customer = DB::table('tb_customer')
                ->where('customer_softdel', 0)
                ->count();

            $total_supplier = DB::table('tb_supplier')
                ->where('supplier_softdel', 0)
                ->count();

            return view('Dashboard.dashboard', $data, [
                'title' => 'Dashboard',
                'total_customer' => $total_customer,
                'total_supplier' => $total_supplier,
            ]);
        } else {
            return redirect('/');
        }
    }
}
