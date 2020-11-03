<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountInfo;
use App\Models\Accounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccountInfoController extends Controller
{

    public function __construct()
    {
        #需要登入才能使用此class
        $this->middleware('userAuth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Accounts $accounts)
    {
        if (Session::get('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
            return view('homepage', ['id' => $data['id'], 'name' => $data['name'], 'balance' => $data['balance']]);
        } else {
            return view('/login');
        }
    }

    public function deposit_page(Accounts $accounts)
    {
        if (Session::get('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
            return view('deposit', ['id' => $data['id'], 'name' => $data['name'], 'balance' => $data['balance']]);
        } else {
            return view('/login');
        }
    }

    public function withdrawal_page(Accounts $accounts)
    {
        if (Session::get('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
            return view('withdrawal', ['id' => $data['id'], 'name' => $data['name'], 'balance' => $data['balance']]);
        } else {
            return view('/login');
        }
    }
    #紀錄
    public function show(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        $start_time = date("Y-m-d H:i:s", strtotime($request->start_time));
        $end_time = date("Y-m-d H:i:s", (strtotime($request->end_time) + 86399));
        $searchData = $accountInfo->searchData($user_id, $start_time, $end_time);
        return $searchData;
    }
    #存款
    public function deposit(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        $number = date("YmdHis", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y'))) . rand(1000, 9999);
        $amount = intval($request->amount);
        $money = intval($request->money);
        $balance = $amount + $money;
        $type = 0;
        $remark = $request->remark;
        $result = $accountInfo->insertData($user_id, $number, $amount, $money, $balance, $type, $remark);
        return $result;
    }
    #提款
    public function withdrawal(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        $number = date("YmdHis", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y'))) . rand(100, 999);
        $amount = intval($request->amount);
        $money = intval($request->money);
        $balance = $amount - $money;
        $type = 1;
        $remark = $request->remark;

        $result = $accountInfo->insertData($user_id, $number, $amount, $money, $balance, $type, $remark);
        return $result;
    }
}
