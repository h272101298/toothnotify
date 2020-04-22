<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Lib\WxNotify;
use App\Models\Make;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifyController extends Controller
{
    //预约成功推送
    public function orderSend(Request $post){
        $wx=new WxNotify();
        $accsstoken=$wx->getAccessToken();
        $userid=$post->userId;
        $caseid=$post->caseId;
        $template_id="ySTGlxFYMme5Q9bHOjnFEjczhvmxYnMiHY5lJcrBnWo";
        $make=new Make();
        $user=new User();
        $order=$make->where('case_id',$caseid)->first();

        $help=DB::table('t_help')->where('help_id',3)->first();
        $address=json_decode($help->help_content);
        $openid=$user->where('user_id',$userid)->first();
        $url="https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=%s";
        $sendurl=sprintf($url,$accsstoken);
        $keyword=[
            'name5'=>[
                'value'=>$post->user_name
            ],
            'thing3'=>[
                'value'=>$address->name
            ],
            'thing6'=>[
                'value'=>$address->address
            ],
            'name10'=>[
                'value'=>"廖亮东"
            ],
            'thing4'=>[
                'value'=>"已成功预约"
            ]
        ];
        $data=[
            'access_token'=>$accsstoken,
            'touser'=>$openid->user_open_id,
            'template_id'=>$template_id,
            'data'=>$keyword,
            'miniprogram_state'=>"formal",
        ];
        $data=json_encode($data);
        $send=$wx->httpRequest($sendurl,$data);
        return response()->json([
            'msg'=>"ok",
            'data'=>$send,
            'da'=>$post->userId
        ]);
    }
}
