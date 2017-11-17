<?php

class IndexController{

    private $base_url ;

    public function __construct()
    {
        $this->base_url = "http://m.suanzao.tv";
    }

    function index(){

        $rest = get($this->base_url);

        $handle  = fopen('test.html', 'w');
        fwrite($handle,$rest);
        fclose($handle);

        echo 'index';


    }

    function category(){

        echo 'category';

    }

    function play(){
        $request_uri = "/dianshiju/aa";
//        $request_uri = "/dianying/";

        if (preg_match('/^\/[a-zA-Z]+\/?$/', $request_uri)){
            echo 'yes';
        }else{
            echo 'no';
        }

        echo "<br>";
        echo 'play';

    }


    function test(){

        echo 'test';

        $handle  = fopen('test.html', 'r');
        $rest = fread($handle, filesize("test.html"));
        fclose($handle);

        $rest = str_replace('酸枣', '57大收录', $rest);

        $rest = str_replace('www.suanzao.tv', 'www.57tv.club', $rest);
        $rest = str_replace('m.suanzao.tv', 'www.57tv.club', $rest);

        $rest = str_replace('/public/tpl/mstyle', '', $rest);


        $rest = preg_replace('/<!--统计代码--><script[^<]+?<\/script>/is', '', $rest);
        $rest = preg_replace('/<!--广告--><script[^<]+?<\/script>/is', '', $rest);

        $handle = fopen('test1.html', 'w');
        fwrite($handle, $rest);
        fclose($handle);

    }
}