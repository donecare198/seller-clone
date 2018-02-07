<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Excel;
use Illuminate\Filesystem\Filesystem;
use App\clone2;
use Carbon\Carbon;
use App\User;
use App\buyclone;
use App\Config;

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
    public function loadConfig(){
        $config = Config::select(['key','value','link'])->get();
        return $config;
    }
    public function viewClone($st = '')
    {
        if($st == ''){
            $clone = clone2::where('status','!=','trash')->where('userid',auth::user()->id)->paginate(20);   
        }else{
            $clone = clone2::where('status',$st)->orderBy('updated_at','ASC')->paginate(20);
            
        }
        $status = clone2::select('status')->distinct()->get();
        $array = ['clone'=>$clone,'status'=>$status];
        return $array;
    }
    public function viewTrash($st = 'trash')
    {
        if($st == ''){
            $clone = clone2::where('userid',auth::user()->id)->paginate(20);   
        }else{
            $clone = clone2::where('status',$st)->orderBy('updated_at','ASC')->paginate(20);
            
        }
        $status = clone2::select('status')->distinct()->get();
        $array = ['clone'=>$clone,'status'=>$status];
        return $array;
    }
    public function infoSystem(){
        $coutClone = clone2::count();
        $coutUser = User::count();
        $daban = clone2::where('daban','=','1')->count();
        $chuaban = clone2::where('daban','=','0')->count();
        return response()->json(['countClone'=>$coutClone,'daban'=>$daban,'chuaban'=>$chuaban,'countUser'=>$coutUser]);
    }
    public function buyClone(Request $request){
        $config = Config::select(['value'])->where('key','clone')->first();
        $chuaban = clone2::where('daban','=','0')->count();
        $loai = $request->loai;
        $soluong = $request->soluong;
        if($soluong*$config->value > auth::user()->money){
            return response()->json(['message'=>'Số tiền trong tài khoản không đủ để thanh toán'],404);
        }
        if($chuaban < $soluong){
            return response()->json(['message'=>'Không đủ clone trong hệ thống'],404);
        }
        $data2 = ['soluong'=>$soluong,
                 'loai'=>$loai,
                 'giatien'=>$soluong*$config->value,
                 'userid'=>auth::user()->id];
        $buy = buyclone::create($data2);
        if($buy){
            User::where('id',auth::user()->id)->update(['money'=>auth::user()->money - $soluong*$config->value]);
        }
        $clone = clone2::where('userid','0')->limit($soluong)->orderBy('id','DESC')->lockForUpdate()->get();
        foreach($clone as $cl){
            clone2::where('id',$cl->id)->update(['daban'=>'1','userid'=>auth::user()->id,'updated_at'=>date('Y-m-d H:i:s',time())]);
            $data[] = array($cl->uid,$cl->email,$cl->password,$cl->cookie,$cl->token,$cl->birthday,$cl->lastname,$cl->firstname,$cl->sex);
        }
        /****************/
        Excel::create('MuaClone_'.$buy->id, function($excel) use($data) {
            $excel->sheet('Sheetname', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->store('xls',storage_path('../excel/'.date('Y-m-d',time())));
        
        return response()->json(['message'=>'Thanh toán thành công']);
    }
    public function downloadClone($id){
        $history = buyclone::select(['userid','created_at'])->where('id',$id)->first();
        if($history->userid != auth::user()->id){
            return response()->json('Bạn không có quyền truy cập vào file này');
        }
        $file = '../excel/'.date('Y-m-d',strtotime($history->created_at)).'/MuaClone_'.$id.'.xls';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
    public function historyBuy(){
        $history = buyclone::where('userid',auth::user()->id)->orderBy('id','DESC')->paginate(10);
        return $history;
    }
    public function trashClone(Request $request){
        $id = $request->id;
        foreach($id as $i){
            $check = clone2::select(['id','userid'])->where('id',$i)->first();
            if($check->userid == auth::user()->id){
                clone2::where('id',$check->id)->update(['status'=>'trash']);
            }
        }
    }
}
