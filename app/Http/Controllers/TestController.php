<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $url = "http://server.1905.com/api/goods?id=1";
        $data = file_get_contents($url);
        echo $data;
    }

    public function encrypt()
    {
        $data = $_GET['data'];

        $method = "AES-256-CBC";
        $key = "1905api";
        $iv = "WUSD8796IDjhkchd";

        $enc_data = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
        echo '加密：' . $enc_data;
        echo "<br>";
        //发送加密数据
        $url = "http://server.1905.com/api/decrypt?data=" . urlencode(base64_encode($enc_data));
        $res = file_get_contents($url);
        echo $res;
    }

    public function rsa1()
    {
        $priv_key = file_get_contents(storage_path('keys/priv.key'));

        $data = '我爱北京';
        openssl_private_encrypt($data, $enc_data, $priv_key);
//        echo '加密数据:'.$enc_data;echo "<br>";


        $base64_encode_str = base64_encode($enc_data);
        echo 'base64:' . $base64_encode_str;
        $url = "http://server.1905.com/api/RsaDecrypt?data=" . urlencode($base64_encode_str);
//        echo $url;
        $res = file_get_contents($url);
        echo $res;
    }

    public function curl1()
    {
        $url = "http://1905api.comcto.com/test/curl1?name=ljx&age=18";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        curl_close($ch);
    }

    public function curl2()
    {
        $url = "http://1905api.comcto.com/test/curl2";
        $data = [
            'name' => 'zhangsan',
            'age' => 123
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }

    public function curl3()
    {
        $url = "http://1905api.comcto.com/test/curl3";
        $data = [
            'img1' => new \CURLFile('a.jpg')
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }

    public function curl4()
    {
        $url = "http://1905api.comcto.com/test/curl4";
        $token = rand(10000, 99999);
        $token = md5($token);
        $data = [
            'name' => 'zhangsan',
            'age' => 18
        ];

        $json_str = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_str);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:text/plian',
            'token:' . $token
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     *
     */
    public function sign1()
    {
        $params = [
            'name'=>'xin',
            'email'=>'xin@qq.com',
            'amount'=>100,
            'date'=>time()
        ];

        ksort($params);
        print_r($params);
        $str="";
        foreach($params as $k=>$v){
            $str .= $k."=".$v.'&';
        }

        //使用私钥加密
        $str=rtrim($str,'&');
        $priv_key=file_get_contents(storage_path('keys/priv.key'));
        openssl_sign($str,$signature,$priv_key,OPENSSL_ALGO_SHA256);

        //base64编码签名
        $sign=base64_encode($signature);
        echo '签名：',$sign;echo '<br>';

        $url="http://api.1905.com/api/sign1?".$str.'&sign='.urlencode($sign);
        echo $url;
    }

    public function sign2()
    {
        $name='hello';
        $params = [
            'name'=>'xin',
            'email'=>'xin@qq.com',
            'amount'=>100,
            'date'=>time()
        ];

        ksort($params);
        print_r($params);
        $str="";
        foreach($params as $k=>$v){
            $str .= $k."=".$v.'&';
        }

        //使用私钥加密
        $str=rtrim($str,'&');
        $priv_key=file_get_contents(storage_path('keys/priv.key'));
        openssl_sign($str,$signature,$priv_key,OPENSSL_ALGO_SHA256);

        //base64编码签名
        $sign=base64_encode($signature);
        echo '签名：',$sign;echo '<br>';

        $url="http://api.1905.com/api/sign1?".$str.'&sign='.urlencode($sign);
        echo $url;
    }
}
