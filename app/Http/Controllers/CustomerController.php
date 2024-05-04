<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerController extends Controller
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

    public function customer(Request $request)
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

            $data = DB::table('punya_farrel.tb_customer')
                ->select('tb_customer.*')
                ->where('customer_softdel', 0);

            if ($request->search) {
                $data->where(DB::raw("CONCAT(`customer_name`,' ',`address`)"), 'like', '%' . $search . '%');
            }

            if ($request->order_name == '') {
                $order_name = 'id_customer';
                $order_type = 'DESC';
            } else {
                $order_name = $request->order_name;
                $order_type = $request->order_type;
            }

            $data->orderBy($order_name, $order_type);

            return view('Master.customer', $user, [
                'title' => 'Customer',
                'data' => $data->paginate($sortir)
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_customer(Request $request)
    {
        $data = new Customer();
        $data->customer_name = $request->customer_name;
        $data->address = $request->address;
        $data->phone_number = $request->phone_number;
        $data->customer_inserted_at = date('Y-m-d H:i:s');
        $data->customer_last_updated = date('Y-m-d H:i:s');
        $data->customer_softdel = 0;

        $data->save();
        if ($data) {
            \Session::put('success', 'Add New Customer Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add New Customer Failed!');
            return redirect()->back();
        }
    }

    public function edit_customer(Request $request)
    {
        $data = Customer::find($request->id_customer);
        $data->customer_name = $request->edit_customer_name;
        $data->address = $request->edit_address;
        $data->phone_number = $request->edit_phone_number;
        $data->customer_last_updated = date('Y-m-d H:i:s');

        $data->save();
        if ($data) {
            \Session::put('success', 'Update Customer Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update Customer Failed!');
            return redirect()->back();
        }
    }

    public function delete_customer(Request $request)
    {
        $data = Customer::find($request->id_customer_delete);
        $data->customer_softdel = 1;

        $data->save();
        if ($data) {
            \Session::put('success', 'Delete Customer Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Delete Customer Failed!');
            return redirect()->back();
        }
    }

    public function get_id_customer($id)
    {
        $data = Customer::find($id);

        return response()->json([
            'status' => 200,
            'customer' => $data,
        ]);
    }
}
