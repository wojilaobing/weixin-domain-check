<?php


namespace app\index\controller;


class WeiXinDomainCheck
{
    // 接口地址
    private $url = "http://api.monkeyapi.com";
    // 请求参数
    private $params = [
        'appkey' => 'appkey',
        'url' => 'www.monkeyapi.com'
    ];

    /**
     * 发起请求
     */
    public function index() {
        $param_string = http_build_query($this->params);
        $content = $this->Curl($this->url, $param_string);
        $result = json_decode($content, true);
        if($result) {
            var_dump($result);
        } else {
            //请求异常
        }
    }


    /**
     * 请求接口返回内容
     * @param    string $url [请求的URL地址]
     * @param    string $params [请求的参数]
     * @param    int $is_post [是否采用POST形式]
     * @return bool|string
     */
    public function Curl($url, $params = '', $is_post = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($is_post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        }else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url.'?'.$params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }
}