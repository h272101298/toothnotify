<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Lib\WxNotify;
use App\Models\Make;
use App\Models\User;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    //预约成功推送
    public function orderSend(Request $post){
        $wx=new WxNotify();
        $accsstoken=$wx->getAccessToken();
        $userid=$post->userid;
        $caseid=$post->caseid;
        $template_id="ySTGlxFYMme5Q9bHOjnFEjczhvmxYnMiHY5lJcrBnWo";
        $make=new Make();
        $user=new User();
        $order=$make->where('case_id',$caseid)->get();
        $openid=$user->where('user_id',$userid)->first();
        $url="https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=%s";
        $sendurl=sprintf($url,$accsstoken);
        //dd($sendurl);
        $keyword=[
            'name'=>[
                'value'=>'123'
            ],
            'thing'=>[
                'value'=>'32'
            ],
            'thing'=>[
                'value'=>"4"
            ],
            'name'=>[
                'value'=>"5"
            ],
            'thing'=>[
                'value'=>"6"
            ]
        ];
        $keyword=json_encode($keyword);
        $data=[
            'access_token'=>$accsstoken,
            'touser'=>$openid->user_open_id,
            'template_id'=>$template_id,
            'data'=>$keyword,
            'miniprogram_state'=>"formal",
        ];
        $data=json_encode($data);
        $send=$wx->httpRequest($sendurl,$data);
        //dd($send);
        return response()->json([
            'msg'=>"ok",
            'data'=>$send
        ]);
    }
    public function saveStatus(){

    }
}
