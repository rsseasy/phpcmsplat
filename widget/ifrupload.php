<?php
include_once('../library/config.php');
include_once(root.'/library/fileuploadthumb.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>上传文件</title>
        <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form id="thisform" method="post" enctype="multipart/form-data">
            <input type="file" id="swfupfile" name="swfupfile" style="position:absolute;top: 0;left: 0; width: 94px; height: 26px; opacity: 0.01" />
            <button type="button"><img src="/img/selectfile.jpg" /></button><button type="submit"><img src="/img/upfile.jpg" /></button>
        </form>
        <?php include_once '../inc/js.html'; ?>        
        <textarea id="upfiledata" class="disno">
            <?php
            $upfile=new FileUploadThumb();
            if ($upfile->upload("swfupfile"))
            {
                echo '{"url":"'.str_replace('/upfile/', '', $upfile->fileinfo->url).'","fileid":'.$upfile->fileinfo->fileid.',"filesize":'.$upfile->fileinfo->filesize.',"error":"'.$upfile->fileinfo->error.'","succeed":'.($upfile->fileinfo->succeed?1:0).',"ext":"'.$upfile->fileinfo->ext.'","filename":"'.$upfile->fileinfo->filename.'","sourcename":"'.$upfile->fileinfo->sourcename.'"}';
            }
            ?>
        </textarea>
        <script type="text/javascript">
            var swfupload=window.parent["swfupload"];
            if(swfupload)
            {
                $("#thisform").submit(function (e)
                {
                    var files=document.getElementById("swfupfile").files;
                    if(!files.length)
                    {
                        alert("请选择一张图片");
                        return;
                    }
                    var filedata=new FormData();
                    filedata.append("swfupfile",files[0]);
                    var xhr=new XMLHttpRequest();
                    function uploadProgress(evt)
                    {
                        if(evt.lengthComputable){
                            swfupload.onprogress(Url["marker"],0,[evt.loaded,evt.total]);
                        }
                    }
                    function uploadComplete(evt)
                    {
                        swfupload.onsucceed(Url["marker"],0,evt.target.responseText);
                    }
                    xhr.open("post",Url["requestUrl"]);
                    xhr.upload.addEventListener("progress",uploadProgress,false);
                    xhr.addEventListener("load",uploadComplete,false);
                    xhr.send(filedata);
                    e.preventDefault();
                });

                var upfiledata=$("#upfiledata").val().trim();
                if(upfiledata)
                {
                    swfupload.onselect(0,this.result);
                }
                $("#swfupfile").change(function ()
                {
                    var files=document.getElementById("swfupfile").files;
                    if(files.length)
                    {
                        var data=new FileReader();
                        data.onload=function ()
                        {
                            swfupload.onselect(Url["marker"],{"key":0,"src":this.result});
                        }
                        data.readAsDataURL(files[0]);
                    }
                });
            }
        </script>
    </body>
</html>
