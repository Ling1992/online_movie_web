<?php
require_once WEB_ROOT . 'lib/Requests.php';
Requests::register_autoloader();

class C_index extends sp_controller {
    function __construct() {
        // die;
    }


    function home(){

        if (isset($_GET['url'])) {

            $url = 'http://v.saohuo.la/' . $_GET['url'];
        
        } else {

            $url = 'http://v.saohuo.la/';

        }

        if (!isset($_GET['debug']) && $cache = $this->cache->get(md5($url))) {

            $body =  $cache . "<!--funck the cache!!!-->";

        } else {

            $headers = ["User_Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], "Referer" => 'http://v.saohuo.la/'];

            $r = Requests::get($url, $headers);
            
            $body = $r->body;

            $this->cache->set(md5($url), $body, 86400);

        }

        $body = $this->filter($body);
            
        echo $body;

    }

    function filter($html){

        $html = str_replace('/templets/saohuo_black/images/main.css', '/static/saohuo/main.css', $html);
        
        $html = str_replace('<a href="/', '<a href="/mv.php/index/?url=', $html);

        $html = preg_replace('/(<a[^>]+?href=\')\//is', '\1?url=' , $html);

        $html = str_replace('http://jiexi.hhplayer.com/subo/', '/mv.php/index/subo?url=http://jiexi.hhplayer.com/subo/', $html);

        $html = str_replace('/search.php', '/mv.php/index/search/', $html);

        $html = str_replace(['saohuotv', '骚火', '<title>'], ['point57', '57点点', '<title>57点点-'], $html);
        //伦理
        $html = str_replace('list/5', 'list/4', $html);

        $html = str_replace('https://jx.023m.com', "/mv.php/index/dpbo?url=https://jx.023m.com", $html);

        $html = preg_replace('/<!--统计代码--><script[^<]+?<\/script>/is', '', $html);

        $html = preg_replace('/<!--广告--><script[^<]+?<\/script>/is', '', $html);

        $html = preg_replace('/<section\s+id="ad_pop.+?<\/section>/is', '', $html);

        $html = preg_replace('/<script\s+src="\/include\/ajax\.php.+?"><\/script>/is', '', $html);

        $html = preg_replace('/(最新电视剧.+)<section.+?最新伦理.+?<\/section>/is', '\1', $html);

        return $html;
    }

    function subo(){
        if (isset($_GET['url'])) {

            $url = $_GET['url'];

            if (count($_GET) > 1) {
                foreach ($_GET as $k => $v) {
                    $url .= "&" . $k . "=" . $v;
                }
            }

        } else {

            die('404');

        }
        // if (!isset($_GET['debug']) && $cache = $this->cache->get(md5($url))) {

        //     $body = $cache;

        // } else {

            $headers = ["User_Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], "Referer" => 'http://v.saohuo.la/'];

            $r = Requests::get($url, $headers);

            $r->body = str_replace('/assets/js/ckplayer/', '/ckplayer/', $r->body);
            
            $r->body = str_replace('/assets/js/jquery-1.11.3.min.js', '/static/saohuo/jquery-1.11.3.min.js', $r->body);

            $r->body = str_replace('$.post(\'/subo/jx', '$.post(\'/mv.php/index/video?url=http://jiexi.hhplayer.com/subo/jx', $r->body);
            
            $body = $r->body;

        //     $this->cache->set(md5($url), $body, 7200);
        // }
            
        echo $body;
    }


    function video(){

        if (isset($_GET['url'])) {

            $url = $_GET['url'];

        } else {

            die('404');

        }

        // if (!isset($_GET['debug']) && $cache = $this->cache->get(md5($url))) {
        //     $body = $cache;

        // } else {

            $headers = ["User_Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], "Referer" => 'http://v.saohuo.la/'];

            $r = Requests::post($url, $headers, $_POST);

            $tmp = json_decode($r->body);

            $tmp->url = "http://jiexi.hhplayer.com" . $tmp->url;

            $body = json_encode($tmp);

        //     $this->cache->set(md5($url), $body, 7200);
        // }

        echo $body;
    }

    function dpbo(){
        
        if (isset($_SERVER['QUERY_STRING'])) {

            $url = substr($_SERVER['QUERY_STRING'], 4);

            if (empty($url) || strpos($url, 'jx.023m.com') == false) {
                
                die('404');
            }

        } else {

            die('404');

        }



        // if (!isset($_GET['debug']) && $cache = $this->cache->get(md5($url))) {
        //     $body = $cache;

        // } else {

            $headers = ["User_Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], 'Host' => 'jx.023m.com'];

            $r = Requests::get($url);

            $headers = ["User_Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], "Referer" => 'http://v.saohuo.la/'];

            $r->body = str_replace(['App/Home/',], ['https://jx.023m.com/playm3u8/App/Home/', ], $r->body);

            $r->body = str_replace('https://jx.023m.com/playm3u8/App/Home/Public/js/player.js', '/static/jx/player.js', $r->body);

            $body = $r->body;

            // $this->cache->set(md5($url), $body, 7200);

        // }

            

        echo $body;
    }

    function jxindexphp(){
       
        $headers = ["User-Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], "Referer" => 'https://jx.023m.com/playm3u8/in dex.php?url=http://www.iqiyi.com/v_19rr83ssog.html',"X-Requested-With"=>"XMLHttpRequest", 'Cookie' => 'PHPSESSID=e41qe8vmtb5fs7k04q86lr29r0', 'Origin' => 'https//jx.023m.com', 'Host' => 'jx.023m.com'];

        $r = Requests::post("https://jx.023m.com/playm3u8/index.php", $headers, $_POST);

        echo $r->body;
    }


    function search(){

        if (isset($_POST) && !empty($_POST)) {

            // $_POST['searchword'] = '同盟';

            $scapi = 'http://v.saohuo.la/search.php';

            $headers = ["User-Agent" => $_SERVER['HTTP_USER_AGENT'], "Accept" => $_SERVER['HTTP_ACCEPT'], "Host" => "v.saohuo.la", "Origin" => "http://v.saohuo.la", "Referer" => "http://v.saohuo.la/", "Upgrade-Insecure-Requests" => "1"];

            $r = Requests::post($scapi, $headers, $_POST);

            $r->body = $this->filter($r->body);

            echo $r->body;

        } else {

            die(404);
        }

    }

}

