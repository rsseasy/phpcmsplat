<?php
//文件操作操作类
class FileExtend {
    //制造文件上传存储目录
    public static function MakeUploadDir() {
        $path=upfile.date("ym");
        self::MakeDir($path);
        $path=$path.date("/dH/");
        return self::MakeDir($path);
    }
    public static function MakeDir($path) {
        if (!is_dir($path)) {
            mkdir($path);
        }
        return $path;
    }
    //创建文件名
    public static function MakeFileName() {
        $name=substr(strtolower(md5(date("ymdhis").session_id().mt_rand())), 8, 16);
        return $name;
    }
    public static function FileMatterReplace($filepath, $findstr, $replacestr) {
        $matter=str_replace($findstr, $replacestr, file_get_contents($filepath));
        $fp=fopen($filepath, "w");
        fwrite($fp, $matter);
        fclose($fp);
    }
    public static function MakeFile($filepath, $matter) {
        $fp=fopen($filepath, "w");
        fwrite($fp, $matter);
        fclose($fp);
    }
    public static function MakeFileUseUrl($Url, $filepath) {
        self::MakeFile($filepath, file_get_contents($Url));
    }
}
?>