<?php

/**
 * Created by PhpStorm.
 * User: Pavlo
 * Date: 17.09.2017
 * Time: 15:47
 */
class Validator
{
    /**
     * validate create-form
     * @param array $post
     * @return array $errors
     */
    public static function createForm( $post = array() )
    {
        $count = 0;
        $messages = array();

        if(empty($post['title']))
        {
            $count++;
            $messages['title'] = "The field title is required!";
        }

        if(empty($post['author']))
        {
            $count++;
            $messages['author'] = "The field author is required!";
        }

        if(empty($post['genre']))
        {
            $count++;
            $messages['genre'] = "The field genre is required!";
        }

        if(empty($post['lang']))
        {
            $count++;
            $messages['lang'] = "The field language is required!";
        }

        if(empty($post['date'])) {
            $count++;
            $messages['date'] = "The field year is required!";
        }

        if(empty($post['isbn'])) {
            $count++;
            $messages['isbn'] = "The field year is required!";
        }

        if ($count == 0 and !self::isbn13($post['isbn'])) {
            $count++;
            $messages['isbn'] = "Code is not valid by standart ISBN13";
        }

        return array(
            'count' => $count,
            'messages' => $messages
        );
    }

    /**
     * validate edit-form
     * @param array $post
     * @return array $errors
     */
    public static function editForm( $post = array() )
    {
        $count = 0;
        $messages = array();


        if(empty($post['title']))
        {
            $count++;
            $messages['title'] = "The field title is required!";
        }

        if(empty($post['author']))
        {
            $count++;
            $messages['author'] = "The field author is required!";
        }

        if(empty($post['genre']))
        {
            $count++;
            $messages['genre'] = "The field genre is required!";
        }

        if(empty($post['lang']))
        {
            $count++;
            $messages['lang'] = "The field language is required!";
        }

        if(empty($post['date'])) {
            $count++;
            $messages['date'] = "The field year is required!";
        }

        if(empty($post['isbn'])) {
            $count++;
            $messages['isbn'] = "The field year is required!";
        }

        if ($count == 0 and !self::isbn13($post['isbn'])) {
            $count++;
            $messages['isbn'] = "Code is not valid by standart ISBN13";
        }

        return array(
            'count' => $count,
            'messages' => $messages
        );
    }

    protected static function photo()
    {

    }

    /**
     * isbn-13 validation
     * @param string $str
     * @return bool $res
     */

    protected static function isbn13($str)
    {
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';

        if (preg_match($regex, str_replace('-', '', $str), $matches)) {
            if(13 !== strlen($matches[1])) return false;
            return true;
        }
        return false;
    }
}