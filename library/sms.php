<?php
//发送短信类
class Sms
{
    public $mobilephone;
    public $matter;
    public $account;
    public $pwd;
    public $url;
    public $shijian;
    public $sign;
    function __construct()
    {
        $this->shijian=date('ymdHis');
    }
    //发送短信
    public function send()
    {
        return file_get_contents($this->url);
    }
    public function QueryBalance()
    {
        return $this->send();
    }
}
//凌凯
class InoLinkCom extends Sms
{
    function __construct()
    {
        $this->account='TCLKJ02825';
        $this->pwd='15810208908';
    }
    public function send()
    {
        $this->url="http://inolink.com/ws/BatchSend.aspx?CorpID=".$this->account."&Pwd=".$this->pwd."&Mobile=".$this->mobilephone."&Content=".iconv('UTF-8','gb2312//IGNORE',$this->sign.$this->matter)."&SendTime=";
        return parent::send();
    }
    public function QueryBalance()
    {
        $this->url="http://inolink.com/WS/SelSum.aspx?CorpID=".$this->account."&Pwd=".$this->pwd;
        return parent::QueryBalance();
    }
}
//助通
class ZtSms extends Sms
{
    public $productid='676767';
    public $xh;
    function __construct()
    {
        $this->account='zhongqi';
        $this->pwd=md5(md5('P9gTkbLQ').$this->shijian);
    }
    public function send()
    {
        $this->url="http://www.ztsms.cn/sendSms.do?username=".$this->account."&tkey=".$this->shijian."&password=".$this->pwd."&mobile=".$this->mobilephone."&content=".urlencode($this->sign.$this->matter)."&dstime="."&productid=".$this->productid."&xh=".$this->xh;
        return parent::send();
    }
    public function QueryBalance()
    {
        $this->url="http://inolink.com/ws/Get.aspx?CorpID=".$this->account."&Pwd=".$this->pwd;
        return parent::QueryBalance();
    }
}
?>
