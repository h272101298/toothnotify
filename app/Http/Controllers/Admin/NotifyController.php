<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Lib\WxNotify;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    //预约成功推送
    public function orderSend(Request $post){
        $wx=new WxNotify();
        $accsstoken=$wx->getAccessToken();
        $openid=$post->openid;
        $template_id="ySTGlxFYMme5Q9bHOjnFEjczhvmxYnMiHY5lJcrBnWo";
        $url="https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=%s";
        $sendurl=sprintf($url,$accsstoken);
        //dd($sendurl);
        $keyword=[
            'name5'=>[
                'value'=>'123'
            ],
            'thing3'=>[
                'value'=>'32'
            ],
            'thing6'=>[
                'value'=>"4"
            ],
            'name10'=>[
                'value'=>"5"
            ],
            'thing4'=>[
                'value'=>"6"
            ]
        ];
        $keyword=json_encode($keyword);
        $data=[
            'access_token'=>$accsstoken,
            'touser'=>$openid,
            'template_id'=>$template_id,
            'data'=>$keyword,
            'miniprogram_state'=>"formal",
        ];
        $data=json_encode($data);
        $send=$wx->httpRequest($sendurl,$data);
        //dd($send);
        return response()->json([
            'msg'=>"",
            'data'=>$send
        ]);
    }
}
