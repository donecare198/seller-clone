<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class buyclone extends Model
{
    protected $table = 'buyclone';
    
    protected $fillable = ['updated_at','created_at','soluong','giatien','loai','userid'];
}
