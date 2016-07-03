<?php
include_once root.'/library/upfilelist.php';
include_once root."/library/fileextend.php";
class UpFileInfo
{
    public $path='';
    public $url='';
    public $fileid=0;
    public $sourcename='';
    public $filename='';
    public $filesize=0;
    public $error='';
    public $ext='';
    public $succeed=false;
}
//文件上传类,支持多文件上传
class FileUpload
{
    public $extension='jpg|gif|png';
    public $filesize=2048000; // 文件大小
    public $filelist=array(); // 上传的文件列表
    public $fileinfo;
    public function upload($fields=NULL)
    {
        if ($fields)
        {
            return isset($_FILES[$fields])&&$this->getfile($_FILES[$fields]);
        }
        foreach ($_FILES as $key=> $value)
        {
            $this->getfile($value);
        }
        return count($this->filelist);
    }
    private function getfile($file)
    {
        $this->fileinfo=new UpFileInfo();
        $this->fileinfo->sourcename=$file['name'];
        $this->fileinfo->filesize=$file['size'];
        try
        {
            if ($this->fileinfo->filesize<=0)
            {
                throw new Exception("上传文件不能为空！");
            }
            if ($this->fileinfo->filesize>$this->filesize)
            {
                throw new Exception('超出允许上传文件的大小'.($this->filesize/1024).'KB！');
            }
            if (!preg_match('/'.$this->extension.'$/i', $this->fileinfo->sourcename, $this->fileinfo->ext))
            {
                throw new Exception("不允许上传的文件！");
            }
            $this->fileinfo->ext=$this->fileinfo->ext[0];
            $entity=new FileExtend();
            $this->fileinfo->filename=$entity->MakeFileName().'.'.strtolower($this->fileinfo->ext);
            $this->fileinfo->path=$entity->MakeUploadDir().$this->fileinfo->filename;
            $this->fileinfo->url=str_replace(root, "", $this->fileinfo->path);
            move_uploaded_file($file['tmp_name'], $this->fileinfo->path);
            $this->fileinfo->fileid=$this->onUpload();
            $this->fileinfo->succeed=TRUE;
        } catch (Exception $ex)
        {
            $this->fileinfo->error=$ex->getMessage();
            $this->fileinfo->succeed=FALSE;
        }
        array_push($this->filelist, $this->fileinfo);
        return $this->fileinfo->succeed;
    }
    private function onUpload()
    {
        $filelist=new UpfileList();
        $filelist->keyvalue("name", $this->fileinfo->sourcename)->keyvalue("url", str_replace("/upfile/", "", $this->fileinfo->url))->keyvalue("size", $this->fileinfo->filesize)->timestamp();
        $filelist->append()->submit();
        return $filelist->autoid;
    }
}
?>
