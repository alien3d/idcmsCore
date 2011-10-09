<?php
mysql_connect("localhost","root","123456");
mysql_select_db("cop");
$dir = ".";

$dh = opendir($dir);

while (($file = readdir($dh)) !== false) {
	echo $file."\n<br>";
	if($file !="." && $file !="..") {
		$sql="INSERT INTO `icon`  (`iconName`) values ('".str_replace(".gif","",str_replace(".png","",$file))."')";
		mysql_query($sql) or die (mysql_error().$sql);
	}
}

closedir($dh);
?>