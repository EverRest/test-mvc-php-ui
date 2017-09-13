<?php

class Helper
{
    /**
     * Return base url
     * @param string $route
     * @return string $protocol
     */
    public static function url($route = false)
    {
//        if ($route) {
//            if(isset($_SERVER['HTTPS'])){
//                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
//            }
//            else{
//                $protocol = 'http';
//            }
//
//            $protocol .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $route;
//            return $protocol;
//
//        } else {
//            die('Error: Wrong url path.');
//        }
    }

    /**
     * Redirect
     * @param string $route
     * @return void
     */
    public static function redirect($str = false)
    {
        $str? header('location: ' . URL . $str) : header('location: ' . URL);
    }
}