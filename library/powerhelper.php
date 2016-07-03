<?php
class PowerHelper
{
    public static function HasPower($offset,$power,$desc=NULL)
    {
        try
        {
            $power=explode(',',$power);
            $powerlist="1";
            foreach($power as $value)
            {
                $powerlist .= str_pad(intval($value,2),53,'0',STR_PAD_LEFT);
            }
            if($desc)
            {
                exit('您没有【'.$desc.'】的权限，请与管理员联系！');
            }
            return substr($powerlist,$offset,1)=="1";
        }catch(Exception $ex)
        {
            return false;
        }
    }
    public static function GetPowerList($power)
    {
        try
        {
            $power=explode(',',$power);
            $powerlist="";
            foreach($power as $value)
            {
                $powerlist .= str_pad(decbin($value),53,'0',STR_PAD_LEFT);
            }
            return $powerlist;
        }catch(Exception $ex)
        {
            return '0';
        }
    }
    public static function GetIntPower($powerlist)
    {
        $len=strlen($powerlist);
        if($len%53>0)
        {
            $len+= $len%53;
            $powerlist=str_pad($powerlist,$len,'0');
        }
        $len=$len/53;
        $power=array();
        for($i=0; $i<$len; $i++)
        {
            array_push($power,bindec(substr($powerlist,$i*53,53)));
        }
        return $power;
    }
}
?>
