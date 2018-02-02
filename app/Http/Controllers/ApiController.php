<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Viplike;
use App\Vipcomment;
use App\Vip;
use App\Share;
use App\Follow;
use App\Review;
use App\history;
use Carbon\Carbon;
use App\User;
use App\history_buy_vip;
use App\transaction;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function me(){
        return response()->json([
            'name'=>auth::user()->name,
            'fbid'=>auth::user()->fbid,
            'email'=>auth::user()->email,
            'money'=>number_format(auth::user()->money).' VNĐ',
            'level'=>auth::user()->level,
            'status'=>auth::user()->status,
            'avatar'=>auth::user()->avatar,
            'access_token'=>auth::user()->access_token
        ],200);
    }
    public function install(Request $request){
        $tinhtien = $request->package * $request->price * ($request->time / 10);
        if(auth::user()->money < $tinhtien){
            return \response()->json(['success'=>'false','message'=>'Bạn không đủ tiền để thanh toán!'],200);
        }
        $check = Vip::where('uid',$request->uid)->where('action',$request->action)->first();

        if($check){
            return \response()->json(['success'=>'false','message'=>'UID đã tồn tại'],200);
        }
        if($request->time == ''){
            $time = '';
        }else{
            $time = $request->time;
        }
        $create = Vip::create([
                    'userid' => auth::user()->id != '' ? auth::user()->id : '',
                    'uid' => $request->uid != '' ? $request->uid : '',
                    'postid' => $request->postid != '' ? $request->uid : '',
                    'price' => $tinhtien ,
                    'action' => $request->action,
                    'type' => json_encode($request->type),
                    'comment' => $request->comment != '' ? $request->comment : '',
                    'limit' => $request->package,
                    'time' => $request->time != '' ? $request->time : '',
                    'rate' => $request->rate != '' ? $request->rate : '0',
                ]);

        if($create){
            User::where('id',auth::user()->id)->update(['money'=>auth::user()->money - $tinhtien]);
            history_buy_vip::create([
                'userid' => auth::user()->id,
                'money' => $tinhtien,
                'vipid' => $create->id,
                'time' => $request->time != '' ? $request->time : ''
            ]);
            return response()->json([
                'success' => 'true',
                'message' => 'Chúc mừng bạn đã thanh toán thành công!'
            ]);
        }else{
            return response()->json([
                'success' => 'false',
                'message' => 'Có lỗi xảy ra. Thanh toán không thành công!'
            ]);
        }
    }
    public function getViplikeID(){
        $action = Input::get('action');
        if($action == 'like'){
            $vipid = Vip::select('limit','uid','time')->where('userid',auth::user()->id)->where('action',Input::get('action'))->paginate(10);
            return \response()->json($vipid);
        }
        if($action == 'comment'){
            $vipid = Vip::select('limit','uid','time')->where('userid',auth::user()->id)->where('action',Input::get('action'))->paginate(10);
            return \response()->json($vipid);
        }
        if($action == 'share'){
            $vipid = Vip::select('')->where('userid',auth::user()->id)->where('action',Input::get('action'))->join('vipshare', 'vip.id', '=', 'vipshare.vipid')->paginate(10);
            return \response()->json($vipid);
        }
        if($action == 'review'){
            $vipid = Vip::select('')->where('userid',auth::user()->id)->where('action',Input::get('action'))->join('review', 'vip.id', '=', 'review.vipid')->paginate(10);
            return \response()->json($vipid);
        }
        if($action == 'follow'){
            $vipid = Vip::select('limit','uid','time')->where('userid',auth::user()->id)->where('action',Input::get('action'))->paginate(10);
            return \response()->json($vipid);
        }
        if($action == 'likefanpage'){
            $vipid = Vip::select('limit','uid','time')->where('userid',auth::user()->id)->where('action',Input::get('action'))->paginate(10);
            return \response()->json($vipid);
        }
    }
    
    public function history(){
        $id = Input::get('id');
        if(!$id){
            $his = history::where('me','0')->where('userid',auth::user()->id)->orderBy('created_at','DESC')->get();
        }else{
            $his = history::select('postid','content')->where('me',$id)->where('userid',auth::user()->id)->orderBy('created_at','DESC')->get();
        }
        return \response()->json($his);
    }

}
