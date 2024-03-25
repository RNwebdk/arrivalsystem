<?php


class Token {

    public static function generate(){
        return Session::set('token', md5(uniqid()));
    }

    public static function check($tokenName, $randomToken){
        if(Session::exists($tokenName) && $randomToken === Session::get($tokenName) ){
            Session::delete($tokenName);
            return true;
        }
        return false;
    }

}