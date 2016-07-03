<?php
include_once ($_SERVER["DOCUMENT_ROOT"].'/library/dictionary.php');
class HttpRequestHelper extends Dictionary
{
    public function request()
    {
        $request=array_merge($_GET,$_POST);
        foreach($request as $fields=> $value)
        {
            $this[$fields]=$value;
        }
        $this->remove(array("action"));
        return $this;
    }
    //从COOKIE中获取KEY/VALUE对
    public function cookie($fields=array())
    {
        if(count($fields))
        {
            $fields=array_keys($_COOKIE);
        }
        foreach($fields as $value)
        {
            $this->$value=isset($_COOKIE[$value])?$_COOKIE[$value]:null;
        }
        return $this;
    }
    public function session($fields=array())
    {
        foreach($fields as $value)
        {
            $this->$value=$_SESSION[$value];
        }
        return $this;
    }
    public function getCookie($key)
    {
        return isset($_COOKIE[$key])?$_COOKIE[$key]:NULL;
    }
}