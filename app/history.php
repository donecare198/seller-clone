<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    protected $table = 'history';
    
    protected $fillable = ['userid','postid','action','status','content','updated_at','me','dachay','tong','uid','type','comment'];
}
