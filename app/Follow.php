<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';
    
    protected $fillable = ['vipid','limit','no','dachay'];
}
