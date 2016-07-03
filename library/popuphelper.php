<?php
class PoPupHelper
{
    public static function write($matter,$iscurrent=false)
    {
        if($iscurrent)
        {
            echo '<script type="text/javascript">if(window.popuplayer) { popuplayer.'.$matter.'; }</script>';
        }else
        {
            echo '<script type="text/javascript">if(parent.popuplayer) { parent.popuplayer.'.$matter."; }</script>";
        }
    }
    public static function javascript($matter)
    {
        echo '<script type="text/javascript">'.$matter."</script>";
    }
    public static function refresh()
    {
        self::javascript("window.parent.location.reload();");
    }
    public static function oncloserefresh()
    {
        self::write("onclose=function(){window.parent.location.reload();}");
    }
    public static function iframereload($winname='workspace')
    {
        self::javascript("top.frames[\"".$winname."\"].location.reload();");
    }
    public static function topreload($html)
    {
        javaScript("if(window.popuplayer) { popuplayer.onclose=function(){top.location.reload();}; }",$html);
    }
    public static function reload()
    {
        self::javascript("location.reload()");
    }
    public static function parentreload()
    {
        self::javascript("parent.location.reload()");
    }
    public static function onclosereload($winname='workspace')
    {
        self::write('onclose=function(){top.frames["'.$winname.'"].location.reload()}');
    }
    public static function resize($width,$height)
    {
        $dict=new Dictionary();
        $dict->keyvalue("width",$width)->keyvalue("height",$height)->keyvalue("resize",1)->keyvalue("complete",1);
        self::write("replaceBox(".$dict->toJson().")");
    }
    public static function display($html,$title='提示信息',$width=300,$height=150)
    {
        $dict=new Dictionary();
        $dict->keyvalue("width",$width)->keyvalue("height",$height);
        self::write("display('".$html."','".$title."',".$dict->toJson().")");
    }
    public static function showHtml($html,$width=300,$height=50)
    {
        $dict=new Dictionary();
        $dict->keyvalue("width",$width)->keyvalue("height",$height);
        self::write("showHtml('<div style=\"margin-top:8px;\">".$html."</div>',".$dict->toJson().")");
    }
    public static function showError($html,$width=300,$height=50)
    {
        $dict=new Dictionary();
        $dict->keyvalue("width",$width)->keyvalue("height",$height);
        self::write($html,$dict->toJson());
    }
    public static function showDisabled()
    {
        self::showError("操作失败：此状态下不允许进行此操作！");
        exit();
    }
    public static function showSucceed()
    {
        self::showHtml("操作成功！",200,50);
        exit();
    }
    public static function close()
    {
        self::write("close()");
    }
}
?>