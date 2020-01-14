<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\Sshkey;

class UserController extends Controller
{
    public function addKey()
    {
        return view('user/addKey');
    }

    public function addKey_do(Request $request)
    {
        $pub_key = $request->input('pub_key');
        $id = Auth::user()->id;
        $info = Sshkey::where(['user_id' => $id])->get();
        if (empty($info)) {
            $res = Sshkey::create([
                'pub_key' => $pub_key,
                'user_id' => $id
            ]);
        } else {
            $res = Sshkey::where(['user_id' => $id])->update([
                'pub_key' => $pub_key,
                'user_id' => $id
            ]);
        }

        if ($res) {
            echo '添加成功';
            echo '<br>';
            echo '公钥内容：' . $pub_key;
            return redirect('home');
        }
    }

    public function decrypt()
    {
        return view('user/decrypt');
    }

    public function decrypt_do(Request $request)
    {
        $data = $request->input('data');
        echo '加密数据：' . $data;
        echo '<hr>';
        $base64_decode_str = base64_decode($data);
        $id = Auth::user()->id;
        $info = Sshkey::where(['user_id' => $id])->first();
        $pub_key = $info->pub_key;
        openssl_public_decrypt($base64_decode_str, $dec_data, $pub_key);
        echo '解密:' . $dec_data;
    }

    public function sign()
    {
        return view('user/sign');
    }

    public function sign_do(Request $request)
    {
        $data = $request->except('_token', 'sign');
        $sign = $request->input('sign');
        $params = [];
        foreach ($data['v'] as $k => $v) {
            $params[$data['k'][$k]] = $v;
        }
        ksort($params);

        $str = "";
        foreach ($params as $k => $v) {
            $str .= $k . "=" . $v . '&';
        }
        $str1 = rtrim($str, '&');
        $str2 = ltrim($str1, '=&');

        $id = Auth::user()->id;
        $info = Sshkey::where(['user_id' => $id])->first();
        $pub_key = $info->pub_key;
        $status = openssl_verify($str2, base64_decode($sign), $pub_key, OPENSSL_ALGO_SHA256);
        var_dump($status);
        echo '<br>';

        if ($status) {
            echo '验签成功';
        } else {
            echo '验签失败';
        }
    }
}
