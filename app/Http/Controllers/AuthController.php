<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function login(Request $request)
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function check_login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $account = DB::table('introduction_to_data.tb_pengguna')
            ->where('NamaPengguna', $username)
            ->where('Password', $password)
            ->first();

        if ($account != null) {
            $check_level = DB::table('introduction_to_data.tb_hak_akses')
                ->where('IdAkses', $account->IdAkses)
                ->first();
            if ($check_level != null) {
                session_start();
                $request->Session()->put('IdPengguna', $account->IdPengguna);
                $request->Session()->put('NamaPengguna', $username);
                $request->Session()->put('logged_in', true);
                $request->Session()->put('IdAkses', $account->IdAkses);
                $request->Session()->save();

                return redirect('dashboard');
            }
        } else {
            \Session::put('error', 'You are not registered in system!');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}