<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountInfo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'accountInfo';

    public function insertData($user_id, $number, $amount, $money, $balance, $type, $remark = "")
    {
        DB::table('accounts')->where('id', $user_id)->lockForUpdate()->get();
        $sqlData = $this->where('number', $number)->first();
        if (empty($sqlData)) {
            $this->insert(array(
                'user_id' => $user_id,
                'number' => $number,
                'amount' => $amount,
                'money' => $money,
                'balance' => $balance,
                'type' => $type,
                'remark' => $remark,
            ));
            DB::table('accounts')->where('id', $user_id)->update(array('balance' => $balance));
            return true;
        } else {
            return false;
        }
    }

    public function searchData($user_id, $start_time, $end_time)
    {
        $sqlData = $this->where('user_id', $user_id)->whereBetween('create_time', [$start_time, $end_time])->orderBy('create_time', 'desc')->get();

        return $sqlData;
    }
}
