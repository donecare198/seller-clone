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
    public function DoVipLike($type = 'like'){
        $i = 0;
        $vipid = Vip::whereIn('action', ['like','comment'])->orderBy('updated_at','ASC')->first();
        if($vipid){
            Vip::where('id',$vipid->id)->update([
                'updated_at'=>date('Y-m-d H:i:s',time())
            ]);   
        }else{
            return response()->json(['message'=>'Không có VIP ID nào trong database']);
        }
        $access_token = 'EAAAAUaZA8jlABALZCGxg9hfglZAbD0mIJRMLTZAuteDNH94ndMEiymXl0ScR2YzbBw01gLoZAJfPwiLaRRkeqjJp1yuZCodNBsLXD5bAmTQwX6NkpKMpvfzkr9b4ispaKe8BRmBeCWo3fszj51DoV5jQ25aw6YkyZAZCha51KbK22ZAv1v4nQ4tDu';
        $clone = clone2::orderBy('updated_at','ASC')->first();
        if($clone){
            clone2::where('id',$clone->id)->update([
                'updated_at'=>date('Y-m-d H:i:s',time())
            ]);            
        }else{
            return response()->json(['message'=>'Không có token nào trong database']);
        }

        $client = new Client();
        if($vipid->action == 'like'){
            $response = $client->get('https://graph.facebook.com/'.$vipid->uid.'/feed?fields=id,privacy,story,created_time&limit=5&access_token='.$access_token);
            $list_id = json_decode($response->getBody()->getContents(),true);
            $type = (array) json_decode($vipid->type);
            foreach($list_id['data'] as $postid){
                $check_postid = history::where('postid',$postid['id'])->where('me',0)->where('action','like')->first();
                if(!$check_postid){
                    $cpostid = history::create([
                        'userid' => $vipid->userid,
                        'postid' => $postid['id'],
                        'action' => $vipid->action,
                        'status' => 'wait',
                        'me' => 0,
                        'uid' => $vipid->uid,                        
                        'dachay' => 0,
                        'tong' => $vipid->limit,
                        'content' => 'Mẹ',
                        'type' => $vipid->type,
                        'comment' => 'null'
                    ]);
                }else{
                    $cpostid = $check_postid;
                }
                $total_like = $client->get('https://graph.facebook.com/'.$postid['id'].'/reactions?fields=&summary=true&access_token='.$access_token);
                $total_like = json_decode($total_like->getBody()->getContents(),true);
                if($total_like['summary']['total_count'] < 300 && $postid['privacy']['value'] != 'SELF' && $postid['privacy']['value'] != 'ALL_FRIENDS'){
                    return response()->json([
                                                'user_id' => $vipid->userid,
                                                'action' => $vipid->action,
                                                'postid' => $postid['id'],
                                                'type' => $type[array_rand($type,1)],
                                                'me' => $cpostid->id,
                                                'uid' => $clone->uid,
                                                'token' => $clone->token
                                            ]);
                }
            }
        }
        if($vipid->action == 'comment'){
            $response = $client->get('https://graph.facebook.com/'.$vipid->uid.'/feed?fields=id,privacy,story,created_time&limit=5&access_token='.$access_token);
            $list_id = json_decode($response->getBody()->getContents(),true);
            $message = explode('|',$vipid->comment);
            foreach($list_id['data'] as $postid){
                if($postid['privacy']['value'] != 'SELF' && $postid['privacy']['value'] != 'ALL_FRIENDS'){
                    $check_postid = history::where('postid',$postid['id'])->where('me',0)->where('action','comment')->first();
                    if(!$check_postid){
                        $cpostid = history::create([
                            'userid' => $vipid->userid,
                            'postid' => $postid['id'],
                            'action' => $vipid->action,
                            'status' => 'wait',
                            'me' => 0,
                            'uid' => $vipid->uid,                        
                            'dachay' => 0,
                            'tong' => $vipid->limit,
                            'content' => 'Mẹ',
                            'type' => 'null',
                            'comment' => $vipid->comment
                        ]);
                    }else{
                        $cpostid = $check_postid;
                    }
                    return response()->json([
                        'user_id' => $vipid->userid,
                        'message' => $message[array_rand($message,1)],
                        'action' => $vipid->action,
                        'postid' => $postid['id'],
                        'me' => $cpostid->id,
                        'uid' => $clone->uid,
                        'token' => $clone->token
                    ]);
                }
            }
        }
    }
    public function DoVipLike2(){
        $vipid = Vip::select('limit','action','uid','userid','postid','type','comment','rate')->whereIn('action', ['like'])->orderBy('updated_at','ASC')->limit(5)->get();
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
        file_put_contents('/var/www/laravel/public/log', json_encode($json).PHP_EOL, FILE_APPEND);
        foreach($json as $j){
            $check = history::select('id')->where('postid',$j['postid'])->where('action',$j['action'])->first();
            if($check){
                history::where('id',$check->id)->update(['dachay' => DB::raw('dachay+1')]);
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