<?php
class IpHelper
{
    public static function toNumber($ip)
    {
        $ips=explode('.',$ip);
        $hex='';
        foreach($ips as $value)
        {
            $hex.=str_pad(dechex($value),2,STR_PAD_LEFT);
        }
        return ip2long($ip);
    }
    public static function toIp($number)
    {
        return long2ip($number);
    }
}