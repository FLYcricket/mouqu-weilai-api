<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
/******************************************************************************

参数说明: 
$max_file_size  : 上传文件大小限制, 单位BYTE 
$destination_folder : 上传文件路径 
$watermark   : 是否附加水印(1为加水印,其他为不加水印); 

使用说明: 
1. 将PHP.INI文件里面的"extension=php_gd2.dll"一行前面的;号去掉,因为我们要用到GD库; 
2. 将extension_dir =改为你的php_gd2.dll所在目录; 
 ******************************************************************************/

//上传文件类型列表  
$uptypes=array(
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);

$max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
$destination_folder="uploadimg/"; //上传文件路径  
$watermark=1;      //是否附加水印(1为加水印,其他为不加水印);  
$watertype=1;      //水印类型(1为文字,2为图片)  
$waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
$waterstring="http://www.xplore.cn/";  //水印字符串  
$waterimg="xplore.gif";    //水印图片  
$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
$imgpreviewsize=1/2;    //缩略图比例  
?>


<?php
//print_r($_FILES);
//exit;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    for ($i=1;$i<=3;$i++){
    if (!is_uploaded_file($_FILES["upfile{$i}"][tmp_name]))
        //是否存在文件
    {
        echo "图片不存在!";
        exit;
    }

    $file = $_FILES["upfile{$i}"];
    if($max_file_size < $file["size"])
        //检查文件大小
    {
        echo "文件太大!";
        exit;
    }

    if(!in_array($file["type"], $uptypes))
        //检查文件类型
    {
        echo "文件类型不符!".$file["type"];
        exit;
    }

    if(!file_exists($destination_folder))
    {
        mkdir($destination_folder);
    }

    $filename=$file["tmp_name"];
    $image_size = getimagesize($filename);
    $pinfo=pathinfo($file["name"]);
    $ftype=$pinfo['extension'];
    $destination = $destination_folder.time().$i.".".$ftype;
    if (file_exists($destination) && $overwrite != true)
    {
        echo "同名文件已经存在了";
        exit;
    }

    if(!move_uploaded_file ($filename, $destination))
    {
        echo "移动文件出错";
        exit;
    }
    if($imgpreview==1)
    {
        $pic[] = $destination;

       //
    }
}

    return $pic;
    //print_r($pic);
}
?>
