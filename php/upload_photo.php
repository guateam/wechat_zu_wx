<?php
require("database.php");
$dir = $_SERVER['DOCUMENT_ROOT']."/photo/";
$save_dir = "/photo/";
$job_number=$_POST['job_number'];
$bg = false;
if(isset($_POST['bg']))$bg = $_POST['bg'];
$allowedExts = array("gif", "jpeg", "jpg", "png","PNG");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);        // 获取文件后缀名

$dict=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u',
        'v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P',
        'Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0'];
$rnd_str = "";
for($i = 0;$i<7;$i++)
{
    $idx = rand(0,count($dict)-1);
    $rnd_str.=$dict[$idx];    
}

if ((
    ($_FILES["file"]["type"] == "image/jpeg") 
    ||  ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))   
)
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo json_encode(["state"=>$_FILES["file"]["error"]]);
    }
    else
    {
        // echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
        // echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
        // echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        // echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"];

        // 判断当期目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists( $dir . $_FILES["file"]["name"]))
        {
            echo json_encode(["state"=>'文件已经存在']);
        }
        else
        {
            $tm = date("ymdhis",time());
            $sv = $save_dir.$rnd_str.$tm.$_FILES["file"]["name"];
            $tm=$dir.$rnd_str.$tm.$_FILES["file"]["name"];
            $tc = (get("technician",'job_number',$job_number))[0];
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            if($tc)
			{
                move_uploaded_file($_FILES["file"]["tmp_name"],$tm );
                add("technician_photo",[['time',time()],['job_number',$job_number],['img',$sv]]);

                if($bg){
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$tc['friend_circle_background']) && $tc['friend_circle_background']!="" && !is_null($tc['friend_circle_background'])){
                        $del_dir = $_SERVER['DOCUMENT_ROOT'].$tc['friend_circle_background'];
                        unlink($del_dir);
                        del("technician_photo",'img',$tc['friend_circle_background']);
                    }
                    set("technician",'job_number',$job_number,[['friend_circle_background',$sv]]);
                }
                $tp_img_id = (get("technician_photo",'img',$sv))[0];
                $tp_img_id = $tp_img_id['ID'];
                echo json_encode(["state"=>1,'url'=>$sv,'ID'=>$tp_img_id]);
            }
            else
			{
                echo json_encode(["state"=>0]);
            }
        }
    }
}
else
{
    echo json_encode(["state"=>"格式错误:".$_FILES["file"]["type"]]);
}

?>