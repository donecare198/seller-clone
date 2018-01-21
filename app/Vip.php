<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vip extends Model
{
    protected $table = 'vip';
    
    
    protected $fillable = [
         'userid',
         'uid',
         'postid',
         'price',
         'action',
         'type',
         'comment',
         'limit',
         'time',
         'rate',
         'updated_at'
    ];
}
