<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

use App\clone2;
use App\Viplike;
use App\Vipcomment;
use App\Vip;
use App\Share;
use App\Follow;
use App\Review;
use App\history;

class agentApiController extends Controller
{
    public function updateClone(){
        $id = Input::get('id');
        $status = Input::get('status');
        $clone = clone2::where('id',$id)->update(['status'=>$status]);
        return \response()->json($clone);
    }
    public function DoVipLike2(){
        $vipid = Vip::select('id','limit','action','uid','userid','postid','type','comment','rate')->whereIn('action', ['like'])->orderBy('updated_at','ASC')->limit(20)->get();
        if($vipid){
            foreach($vipid as $v){
                Vip::where('id',$v->id)->update([
                    'updated_at'=>date('Y-m-d H:i:s',time())
                ]);
                $clone = clone2::select('id','token')->orderBy('updated_at','ASC')->first();
                if($clone){
                    clone2::where('id',$clone->id)->update([
                        'updated_at'=>date('Y-m-d H:i:s',time())
                    ]);
                }
                $json[] = array(
                    'action' => $v->action,
                    'uid' => $v->uid,
                    'userid' => $v->userid,
                    'postid' => $v->postid,
                    'type' => json_decode($v->type),
                    'comment' => explode('|',$v->comment),
                    'rate' => $v->rate,
                    'cloneid' => $clone->id,
                    'limit' => $v->limit,
                    'token' => $clone->token
                    );
            }
            return response()->json($json);
        }else{
            return response()->json(['success'=>'false','message'=>'Không có VIP ID'],404);
        }
    }
    public function testSub(){
        
                $clone = clone2::select('id','token')->orderBy('updated_at','ASC')->first();
                if($clone){
                    clone2::where('id',$clone->id)->update([
                        'updated_at'=>date('Y-m-d H:i:s',time())
                    ]);
                }
                $json[] = array(
                    'action' => 'sub',
                    'uid' => '100004520190007',
                    'userid' => '1',
                    'postid' => 'null',
                    'type' => 'null',
                    'comment' => 'null',
                    'rate' => 'null',
                    'cloneid' => $clone->id,
                    'limit' => 'null',
                    'token' => $clone->token
                    );
            return response()->json($json);
    }
    public function testLikePage(){
        
                $clone = clone2::select('id','token')->orderBy('updated_at','ASC')->first();
                if($clone){
                    clone2::where('id',$clone->id)->update([
                        'updated_at'=>date('Y-m-d H:i:s',time())
                    ]);
                }
                $json[] = array(
                    'action' => 'likepage',
                    'uid' => '1644961625574912',
                    'userid' => '1',
                    'postid' => 'null',
                    'type' => 'null',
                    'comment' => 'null',
                    'rate' => 'null',
                    'cloneid' => $clone->id,
                    'limit' => 'null',
                    'token' => $clone->token
                    );
            return response()->json($json);
    }
    public function upClone(){
        $str = '';
        $str = explode(PHP_EOL,$str);
        foreach($str as $st){
            $s = explode('|',$st);
            $clone = clone2::create([
                'uid' => $s[0],
                'email' => '$s[1]',
                'password' => $s[1],
                'cookie' => $s[2],
                'token' => $s[3],
                'note' => 'null',
                'birthday' => 'null',
                'lastname' => 'null',
                'firstname' =>'null',
                'linksp' =>'null'
            ]);
            //return response()->json($clone);
        }
    }
    public function DoResult(){
        $json = Input::post('json');
        foreach($json as $j){
            $check = history::select('id')->where('postid',$j['postid'])->where('action',$j['action'])->first();
            if($check){
                history::where('id',$check->id)->update(['dachay' => DB::raw('dachay+1'),'updated_at'=>date('Y-m-d H:i:s',time())]);
                history::create([
                    'userid' => $j['userid'],
                    'content' => $j['content'],
                    'postid' => $j['postid'],
                    'action' => $j['action'],
                    'me' => $check->id,
                    'uid' => $j['uid'],
                    'type' => $j['type'] == '' ? 'null' : $j['type'],
                    'comment' => $j['comment'] == '' ? 'null' : $j['comment']
                ]);
            }else{
                history::create([
                    'userid' => $j['userid'],
                    'content' => $j['content'],
                    'postid' => $j['postid'],
                    'action' => $j['action'],
                    'me' => '0',
                    'uid' => $j['uid'],
                    'type' => $j['type'],
                    'tong' => $j['limit'],
                    'dachay' => '1',
                    'type' => $j['type'] == '' ? 'null' : $j['type'],
                    'comment' => $j['comment'] == '' ? 'null' : $j['comment']
                    ]);
            }
        }
        return 'true';
    }
    public function history(){
        file_put_contents('/var/www/laravel/public/log', Input::get('userid').' '.Input::get('content').PHP_EOL, FILE_APPEND);

    } 
}