<?php
class Xss
{
    public static function clean($array) {
        $strainer = array("<", ">");
        foreach($array as $num => $xss) {
            $array[$num] = str_replace($strainer, "|", $xss);
        }
        return $array;
    }
}
?>