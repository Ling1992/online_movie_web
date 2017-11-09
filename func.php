<?php


function get($url, $params=[], $headers= []){
    return request('get', $url, $params, $headers);
}

function post($url, $params=[]){
    return request('post', $url, $params);
}

function request($method="get", $url,$params=[], $headers= []){

    $method = strtoupper($method);

    $opts = array(
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_3 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) CriOS/62.0.3202.70 Mobile/14G60 Safari/602.1',
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
