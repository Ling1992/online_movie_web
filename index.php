<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 09/11/2017
 * Time: 9:37 AM
 */

require_once 'func.php';


print_r($_SERVER);
$request_uri = $_SERVER['REQUEST_URI'];

if($request_uri == '/favicon.ico' or $request_uri == 'favicon.ico'){
    print_r($request_uri);
}else{
//    print_r($_SERVER['REQUEST_URI']);
//    $myfile = fopen("testfile1.txt", "w");
//    fwrite($myfile, $request_uri);
//    fclose($myfile);

//    $api = 'http://m.hddyy.cc';
//    print_r($api.$request_uri);
//
//    //echo get($api.$request_uri,[], ['Accept:'.$_SERVER['HTTP_ACCEPT']]);
//
//    $res = get($api.$request_uri,[], ['Accept:'.$_SERVER['HTTP_ACCEPT']]);
//
    $myfile = fopen("testfile.txt", "w");
    fwrite($myfile, $request_uri);
    fclose($myfile);
}


//$api = 'http://m.hddyy.cc';
//print_r($api.$request_uri);
//
////echo get($api.$request_uri,[], ['Accept:'.$_SERVER['HTTP_ACCEPT']]);
//
//$res = get($api.$request_uri,[], ['Accept:'.$_SERVER['HTTP_ACCEPT']]);
//
//$myfile = fopen("testfile.txt", "w");
//fwrite($myfile, $res);
//fclose($myfile);