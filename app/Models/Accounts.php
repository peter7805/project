<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Accounts extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    /**
     * 指定是否模型應該被戳記時間。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 抓取帳戶資料。
     */
    public function selectData($account)
    {
        //Query Builder寫法
        $sqlData = $this->where('account', $account)->orWhere('id', $account)->first();
        //Eloquent ORM寫法
        // $sqlData = Accounts::where('account', $account)->orWhere('id', $account)->first();
        return $sqlData;
    }

    /**
     * 更新帳號登入失敗資料。
     */
    public function loginFaile($account, $login_failed, $login_time)
    {
        $this->where('account', $account)->update(['login_failed' => $login_failed, 'login_time' => $login_time]);
        return true;
    }

    /**
     * 註冊資料。
     */
    public function signupData($name, $account, $userId, $password, $balance = 0, $login_failed = 0)
    {
        $sqlData = $this->where('account', $account)->first();
        if (empty($sqlData)) {
            $this->insert(array(
                'name' => $name,
                'account' => $account,
                'userId' => $userId,
                'password' => $password,
                'balance' => $balance,
                'login_failed' => $login_failed,
            ));
            return true;
        } else {
            return '此帳號已被使用，請使用其他帳號';
        }
    }
}
