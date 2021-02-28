<?php

namespace App\Http\Controllers;

use Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\RecitalPlanNotification;
use Illuminate\Support\Facades\Log;

class RecitalPlanSendController extends Controller
{
  public function RecitalPlanSend(Request $request)
  {
      
    $admid = $request::input('admid');
    $emailadr = 'yoshida@mocotech-systemserver.net';
    $title = 'テストタイトル';
    $name = 'シンフォニー先生';
    $text = $name."　様\n発表会曲のかぶりが出ました。あなたの生徒様に他の方と重なってもよいか聞いてお返事を頂いて下さい。その内容を教室へメールでご連絡頂いたのちに、先に選んだ方にお問合せして、先方もＯＫなら、演奏可能となります。";
//	$to = [
//		[
//			'name' => $name,
//			'email' => $emailadr
//		]
//	];
    $to="$emailadr";
	/*
	 *  Mail::to($to)
        ->cc($cc)
        ->bcc($bcc)
        ->send(new SampleNotification($name, $text));
	 */
        $rtn = Mail::to($to)->send(new RecitalPlanNotification($title, $text));
        Log::debug('メールしました'.$admid);
        return response()->json(['rtncode'=>'OK','admid'=>$admid]);
        
        
  }
}
