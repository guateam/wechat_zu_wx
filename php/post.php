<?php  
function curl_post($url='',$postdata='',$options=array())
{
    $ch=curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if(!empty($options))
	{
        curl_setopt_array($ch, $options);
    }
    $data=curl_exec($ch);
    curl_close($ch);
    return $data;
}
$url=curl_post($_POST['url'],$_POST['data']);
echo($url);
?> 