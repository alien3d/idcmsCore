<?php

/* Edit disini untuk mysql dan folder extjs*/
$host          = "localhost";
$user_mysql    = "root";
$pwd           = "";
$db            = "dbchat";
$ext_folder 	= "../ext-3.1.0"; 



//variabel konstan jangan dirubah !!!
   define("HOST",$host);
   define("MYSQL_USER",$user_mysql);
   define("PASSWD",$pwd);
   define("DATABASE",$db);
   
   
  //koneksi database
require_once("classes/sql.class.php");
$Con  = new sql();
$Con->set_koneksi(HOST,MYSQL_USER,PASSWD,DATABASE);
 ?>