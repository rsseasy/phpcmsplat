<?php
//图片处理扩展类
class GraphicsExtend {
    static function ValidateCodeForCookie($var, $width=43, $height=18, $fontsize=16) {
        setcookie($var, self::ValidateCodeMake($width, $height, $fontsize), null, '/');
    }
    static function ValidateCodeForSession($var) {
        session_start();
        session_register(self::ValidateCodeMake());
    }
    //创建验证码
    static function ValidateCodeMake($width=43, $height=18, $fontsize=16) {
        $type='gif';
        header("Content-type: img/".$type);
        $string='0123456789';
        $len=strlen($string);
        $tmp='';
        for ($i=0; $i<5; $i++) {
            $tmp.=substr($string, rand(0, $len-1), 1);
        }
        if ($type!='gif'&&function_exists('imagecreatetruecolor')) {
            $im=@imagecreatetruecolor($width, $height);
        } else {
            $im=@imagecreate($width, $height);
        }
        $r=Array(225, 211, 255, 223);
        $g=Array(225, 236, 237, 215);
        $b=Array(225, 236, 166, 125);
        $key=rand(0, 3);
        $backColor=ImageColorAllocate($im, $r[$key], $g[$key], $b[$key]); // 背景色（随机）
        $borderColor=ImageColorAllocate($im, 0, 0, 0); // 边框色
        $pointColor=ImageColorAllocate($im, 255, 170, 255); // 点颜色
        @imagefilledrectangle($im, 0, 0, $width-1, $height-1, $backColor); // 背景位置
        @imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor); // 边框位置
        $stringColor=ImageColorAllocate($im, 0, 0, 0);
        for ($i=0; $i<=100; $i++) {
            $pointX=rand(2, $width-2);
            $pointY=rand(2, $height-2);
            @imagesetpixel($im, $pointX, $pointY, $pointColor);
        }

        imagettftext($im, $fontsize, 0, 10, 20, $stringColor, 'arial.ttf', $tmp);

        $ImageFun='image'.$type;
        $ImageFun($im);
        @ImageDestroy($im);
        return $tmp;
    }
    // 图片缩放：$path-原始图片路径,$mode-缩放模式(w:按宽,h:按高,z:按比例),$value:不同模式对应的值,$ext-文件保存地址中增加的字符
    public static function Zoom($path, $mode, $value, $ext='l') {
        $size=getimagesize($path);
        $s=$value; // 缩放比例
        switch ($mode) {
            case 'w':
                $s=$value/$size[0];
                break;
            case 'h':
                $s=$value/$size[1];
        }
        $w=round($size[0]*$s);
        $h=round($size[1]*$s);
        $im=imagecreatetruecolor($w, $h);
        switch ($size[2]) {
            case 2:
                $oim=imagecreatefromjpeg($path);
                break;
            case 3:
                $oim=imagecreatefrompng($path);
                break;
        }
        imagecopyresampled($im, $oim, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
        switch ($size[2]) {
            case 2:
                imagejpeg($im, str_replace('.jpg', $ext.'.jpg', $path));
                break;
            case 3:
                imagepng($im, str_replace('.png', $ext.'.png', $path));
                break;
        }
        imagedestroy($im);
    }
}
?>