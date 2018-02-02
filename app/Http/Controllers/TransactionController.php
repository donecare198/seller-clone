<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\transaction;

class TransactionController extends Controller
{
    public function RandomID(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 12; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }
    public function checkTransactionID($code){
        $tran = transaction::where('transactionid',$code)->first();
        if($tran){
            return true;
        }else{
            return false;
        }
    }
    public function addTransaction(){
        $user = auth::user()->id;
        $money = Input::post('money');
        $tran = transaction::where('userid',$user)->whereNotIn('status',['done'])->orderBy('id','DESC')->get();
        if(sizeof($tran) >= 5){
            $rsp = ['success'=>'false','message'=>'Bạn không thể tạo quá nhiều lệnh nạp tiền'];
            return response()->json($rsp,401);
        }else{
            $code = $this->RandomID();
            if($this->checkTransactionID($code) == false){
                $rsp = ['success'=>'true','message'=>$code];   
            }else{
                $this->addTransaction();
            }
            return response()->json($rsp,200);
        }
    }
    
    public function naptien(Request $request){
        $transaction = transaction::create([
            'userid' => auth::user()->id,
            'money' => $request->money,
            'transactionid'=>Input::post('code'),
            'note' => 'null',
            'status' => 'pending',
            'admin' => 'auto'
            
        ]);
        return response()->json(['id'=>$transaction->id]);
    }
    public function getTransaction(){
        $transaction = transaction::where('userid',auth::user()->id)->get();
        if($transaction){
            return $transaction;
        }else{
            return response()->json(['message'=>'Không có transaction nào tồn tại']);
        }
    }
}
