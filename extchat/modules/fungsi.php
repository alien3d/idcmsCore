<?php
  //fungsi-fungsi
   function GetReq($str) {
  $str = isset($_GET["$str"])?$_GET["$str"]:null;
  return $str;
  }

  function PostReq($str) {
  $str = isset($_POST["$str"])?$_POST["$str"]:null;
  return $str;
  }
  
  function nohtml($string) {
   $string = htmlspecialchars($string); //agar kode html tidak diijinkan
   $string = ereg_replace("\n","<br>",$string); //merubah karakter enter jadi br
   return($string);
  }
 ?>
