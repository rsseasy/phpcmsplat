<?php
include_once('../library/config.php');
include_once(root.'/library/fileuploadthumb.php');
$upfile=new FileUploadThumb();
if ($upfile->upload("swfupfile")) {
    
}
echo '{"url":"'.str_replace('/upfile/', '', $upfile->fileinfo->url).'","fileid":'.$upfile->fileinfo->fileid.',"filesize":'.$upfile->fileinfo->filesize.',"error":"'.$upfile->fileinfo->error.'","succeed":'.($upfile->fileinfo->succeed?1:0).',"ext":"'.$upfile->fileinfo->ext.'","filename":"'.$upfile->fileinfo->filename.'","sourcename":"'.$upfile->fileinfo->sourcename.'"}';
?>