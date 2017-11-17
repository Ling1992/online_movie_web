<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 09/11/2017
 * Time: 9:37 AM
 */

$request_uri = $_SERVER['REQUEST_URI'];

$params_arr = explode("/", $request_uri);

require_once 'func.php';

include "./controller/IndexController.php";

error_reporting(E_ALL^E_NOTICE^E_WARNING);

try{
//    / ->0 1  /aa/ -> 0 1 2  /aa/sss

    if ($params_arr[1]){

        if (preg_match('/^\/[a-zA-Z]+\/?$/', $request_uri)){

            call_user_func_array([new IndexController(), "category"], $params_arr);

        }else if (preg_match('/^\/[a-zA-Z]+\/?$/', $request_uri)){

        }

    }else{
        call_user_func_array([new IndexController(), 'index'], []);

    }

}catch (Exception $e){
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    exit;

}

