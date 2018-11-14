<?php  
function curl_get($url)
{
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HEADER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result=curl_exec($ch);
    curl_close($ch);
    return substr($result,strpos($result,'{'),strlen($result)-1);
}
$url=curl_get($_POST['url']);
echo($url);
?> 