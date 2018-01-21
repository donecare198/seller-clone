<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history_buy_vip extends Model
{
    protected $table = 'history_buy_vip';
    
    protected $fillable = [
        'userid',
        'money',
        'vipid',
        'time'
    ];
}
