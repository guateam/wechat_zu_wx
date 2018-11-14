<?php

/**
 * 获$table表内$label符合条件$value的所有数据
 */
function get($table,$label="",$value="")
{
	$DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
	$DB = "wechat_zu";

	$mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
	
    $statement="";
    if($label=="" && $value=="")
	{
		$statement = "SELECT * FROM $table";
	}
    else
	{
        $statement = "SELECT * FROM `$table` WHERE `$label` = '$value'";
    }
    $result = $mysqli->query($statement);
    if($result->num_rows<=0)
	{
		return [];
	}

    $data=[];
    while($row = $result->fetch_assoc())
	{
        array_push($data,$row);
    }
	$mysqli->close();	
    return $data;
}

function getSearch($table,$label="",$value="")
{
	$DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
	$DB = "wechat_zu";
	
    $mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $statement="";

    if($label=="" && $value=="")
	{
		$statement = "SELECT * FROM $table";
	}
    else
	{
        $statement = "SELECT * FROM $table WHERE $label LIKE '%$value%'";
    }
    $result = $mysqli->query($statement);
    if($result->num_rows<=0)
	{
		return [];
	}
    $data=[];
    while($row = $result->fetch_assoc())
	{
        array_push($data,$row);
    }
	$mysqli->close();
    return $data;
}

/**
 * 获$table表内从$index条开始，$label符合条件$value的最有限条数据数据
 */
function get_limit($table,$index=0,$label="",$value="")
{
	$DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
    $DB = "wechat_zu";
    
    $mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $statement="";

    if($label=="" && $value=="")
	{
		$statement = "SELECT * FROM $table LIMIT $index,20";
	}
    else
	{
        $statement = "SELECT * FROM $table WHERE $label = '$value'";
    }
    $result = $mysqli->query($statement);
    if($result->num_rows<=0)
	{
		return [];
	}
    $data=[];
    while($row = $result->fetch_assoc())
	{
        array_push($data,$row);
    }
	$mysqli->close();
    return $data;
}


/**
 * 改变$table表中$label为$value的字段，改变的内容为$change，格式如下
 * [  [字段，值],[字段，值],[字段，值]  ]
 */
function set($table,$label,$value,$change)
{
	$DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
	$DB = "wechat_zu";
    $mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $item = get($table,$label,$value);
    foreach($change as $each)
	{
        $lb = $each[0];
        $vl = $each[1];
        $statement = "UPDATE `$table` SET `$lb`='$vl' WHERE `$label`= '$value'";
        $mysqli->query($statement);
    }
	$mysqli->close();
}

/**
 * 向$table表中添加项，$array格式如下
 * [  [字段，值],[字段，值],[字段，值]  ]
 */
function add($table,$array)
{
	$DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
	$DB = "wechat_zu";
	
    $mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $statement = "INSERT INTO $table (";
    foreach($array as $two)
	{
        $statement.=$two[0].", ";
    }
    $statement = substr($statement, 0, strlen($statement)-2);
    $statement.=") VALUES (";
    foreach($array as $two)
	{
        $statement.="'".$two[1]."', ";
    }
    $statement = substr($statement, 0, strlen($statement)-2);
    $statement.=")";
    $mysqli->query($statement);
	$mysqli->close();
}


function del($table,$label,$value)
{
    $DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
	$DB = "wechat_zu";
	
    $mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $statement = "DELETE FROM `$table` WHERE `$label` = '$value'";
    $mysqli->query($statement);
	$mysqli->close();
}


function sql_str($sql)
{
	$DBServer = "127.0.0.1";	
	$DBUser = "root";
	$DBPass = "smhhyyz508234";		
	$DB = "wechat_zu";
	
    $mysqli = new mysqli($DBServer,$DBUser,$DBPass,$DB);
    if (!$mysqli)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $result = $mysqli->query($sql);

    if(!$result)return false;

    if($result->num_rows <= 0)
	{
		return [];
	}
    $data=[];
    while($row = $result->fetch_assoc())
	{
        array_push($data,$row);
    }
	$mysqli->close();
    return $data;
}
?>