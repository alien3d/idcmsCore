<?php
 require_once("config.php");
 require_once("modules/fungsi.php");
 session_start();
 session_register("username","usermode","ses_id");
 $ses= session_id();
 $_SESSION["ses_id"] = $ses;
 $_SESSION["usermode"] = "1";
 
 /* untuk membersihkan tabel chat jika tidak ada user */
 DeleteChat("tuser_session","chat");
 DeleteChat("tpriv_session","chat_priv");
 
 
 function DeleteChat($tsession,$tchat) {
  global $Con;
  $sekarang = time();
  $hapus = $sekarang - 6 ; //akan dihapus jika sudah 6 detik tidak ada aktivitas
  $str = "select session_time from $tsession where session_time > '$hapus'";
  $jumlah = $Con->select_sql($str,GET_ROW);
  $hitung = $Con->row_count;
 if ($hitung <=0 ) {
   $str = "select count(*) from $tchat";
   $result = $Con->select_sql($str,GET_ROW);
  if ($result[0][0] >0)
    $Con->exec_sql("TRUNCATE TABLE $tchat");
 }
}


 function cekuser($usercek) {
  global $Con;
  $timex = time();
  $_time = $timex - 6;
  $str1 = "select session_username from tuser_session where session_username like '$usercek'";
  $str1 .= " and session_time > '$_time'";
  $str2 = "select session_username from tpriv_session where session_username like '$usercek'";
  $str2 .= " and session_time > '$_time'";
  $result1 = $Con->select_sql($str1);
  $result2 = $Con->select_sql($str2);
  if ($result1 || $result2) {
     return "{success:false}";
  } else {
   $_SESSION["username"] = $usercek;
   return "{success:true,user:'$usercek'}";
  }

 }

if (PostReq("txtuser")){
	echo cekuser(PostReq("txtuser")); 
}

?>
