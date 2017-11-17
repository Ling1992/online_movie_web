<?php


function get($url, $params=[]){
    return request('get', $url, $params);
}

function post($url, $params=[]){
    return request('post', $url, $params);
}

function request($method="get", $url,$params=[]){

    $method = strtoupper($method);

    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_HTTPHEADER => ["Accept:{$_SERVER['HTTP_ACCEPT']}", 'Referer: http://m.suanzao.tv'],
        //Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_3 like Mac OS X) AppleWebKit/603.3.8 (KHTML, like Gecko) Mobile/14G60 MicroMessenger/6.5.21 NetType/WIFI Language/zh_CN
        //Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 MicroMessenger/6.5.2.501 NetType/WIFI WindowsWechat QBCore/3.43.691.400 QQBrowser/9.0.2524.400
        CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => $method,
    );

    // Handle the encoding if we can.
    if (extension_loaded('zlib')) {
        $opts[CURLOPT_ENCODING] = 'gzip,deflate';
    }

    switch ($method) {
        case "POST":
            //POST 是传JSON
            $opts[CURLOPT_POSTFIELDS] = ($params);
            $opts[CURLOPT_HTTPHEADER] = array('Content-Type: multipart/form-data; charset=utf-8', 'Content-Length: ' . strlen($params));
            break;
        case "GET":
            $params = http_build_query($params);
            if($params){
                $opts[CURLOPT_URL] .= "?" . $params;
            }
            break;
    }

    //初始化并执行CURL REQUEST
    $ch = curl_init();

//    print_r($opts);

    curl_setopt_array($ch, $opts);

    $result = curl_exec($ch);
    $errorNo = curl_errno($ch);

    curl_close($ch);

    if ($errorNo) {
        print_r($errorNo);
        die('curl 400');
    } else {
        return $result;
    }
}