<?php
//文件上传并生成缩略图类
include_once ($_SERVER["DOCUMENT_ROOT"] . '/library/fileupload.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/library/graphicsextend.php');
class FileUploadThumb extends FileUpload {
    public function upload($fields = NULL, $params = array()) {
        $ret = parent::upload($fields);
        if ($ret) {
            $this->thumb($params);
        }
        return $ret;
    }
    private function thumb($params) {
        $thumb = new GraphicsExtend();
        if (!isset($params['value'])) {
            $params['value'] = '200';
        }
        if (!isset($params['mode'])) {
            $params['mode'] = 'w';
        }
        if (!isset($params['ext'])) {
            $params['ext'] = 'l';
        }
        foreach ($this->filelist as $key => $value) {
            if ($value->succeed) {
                $thumb->Zoom($value->path, $params['mode'], $params['value'], $params['ext']);
            }
        }
    }
}
?>
