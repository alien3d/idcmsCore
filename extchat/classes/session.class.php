<?php 
  class user_session {
       var $db = null;
       var $table = "";
       var $session_id;
       var $session_username;
       var $session_usermode;
       var $session_time;
       var $session_expired;
       var $session_ip;
       var $total_online=0;
       var $total_member=0;
       var $total_guest=0;
       var $menit;
       var $username = array();

  function __construct($db,$session_id,$table="tuser_session") {
  $this->db = $db;
  $this->table = $table;
  $this->session_id = $session_id;
  }

  function getSession($menit=5) {
  if (!is_numeric($menit))
     $menit = 5;

  $this->menit = $menit;
  if (!$_SESSION["username"]) {
   $this->session_username="Guest";
   $this->session_usermode="-1";
  } else {
   $this->session_username= $_SESSION["username"];
   $this->session_usermode= $_SESSION["usermode"];
  }

   $session_time = time();
   $this->session_expired = $session_time - (60 * $menit);
   $this->session_time = $session_time;
   $this->getIp();
   $this->cekSession();
  }

  function getIp() {
   $ip = getenv("HTTP_X_FORWARDED_FOR");
     if (getenv("HTTP_X_FORWARDED_FOR") == '')
        $ip = getenv("REMOTE_ADDR");
   $this->session_ip = $ip;
  }

  function cekSession() {
  $db = $this->db;
  $table = $this->table;
  $session_id = $this->session_id;
  $str = "select * from $table where session_id='$session_id'";
  $result = $db->select_sql($str,GET_ROW);
  if ($result)
    $this->updateSession();
  else
    $this->insertSession();

  $this->countUser();
  $this->deleteSession();
  }

  function updateSession() {
   $table = $this->table;
   $str = "update $table set session_time='$this->session_time',";
   $str .= " session_username='$this->session_username',";
   $str .= " session_ip = '$this->session_ip',";
   $str .= " session_usermode= '$this->session_usermode'";
   $str .= " where session_id = '$this->session_id'";
   $result = $this->db->exec_sql($str);
  }

  function insertSession() {
   $table = $this->table;
   $str  = "insert into $table";
   $str .= " (session_time,session_visit,session_username,session_usermode,session_id,session_ip)";
   $str .= " values('$this->session_time','$this->session_time','$this->session_username',";
   $str .= "'$this->session_usermode','$this->session_id','$this->session_ip')";
   $result = $this->db->exec_sql($str);
  }

  function deleteSession() {
   $table = $this->table;
   //$this->notice_server();
   $str = "delete from $table where session_time < '$this->session_expired'";
   $result = $this->db->exec_sql($str);
  }
  
  function notice_server() {
  	  $str = "select session_username from $this->table where session_time < '$this->session_expired'";
  	  $result = $this->db->select_sql($str,GET_ROW);
  	  if ($result)
  	  	  foreach ($result as $rows) 
  	  	     foreach ($rows as $field) {
  	  	     	 $posted_on = date("j-m-Y H:i:s");
  	  	     	 $user 		= $field;
  	  	     	 $message	= "$field leaving the chat room";
  	  	     	 $str  = "insert into chat (posted_on,user_name,message)";
  	  	     	 $str .= " values('$posted_on','$user','$message')";
  	  	     	 $this->db->exec_sql($str); 
  	  }
  	  
  }

  function countUser() {
   $table = $this->table;
   $Mstr = "select count(*) from $table where session_time > '$this->session_expired'";
   $result = $this->db->select_sql($Mstr,GET_ROW);
   if ($result)
      $this->total_online = $result[0][0];

   $str = $Mstr .  " and session_usermode <=0";
   $result = $this->db->select_sql($str,GET_ROW);
   if ($result)
      $this->total_guest = $result[0][0];

   $str = $Mstr .  " and session_usermode >0";
   $result = $this->db->select_sql($str,GET_ROW);
   if ($result) {
      $this->total_member = $result[0][0];
      $this->getUsername();
   }

  }
  
  function getUsername() {
   $str = "select session_username from $this->table where session_time ";
   $str .= " > '$this->session_expired' and session_usermode >0 order by session_username";
   $result = $this->db->select_sql($str,GET_ROW);
   $_user = array();
   if ($result)
      foreach($result as $row) {
        foreach ($row as $item)
             $_user[] = $item;  }
   $this->username = $_user;
  }

  function display() {
   $users = implode(",",$this->username);
   echo "Total Online " . $this->total_online . "<br>";
   echo "Total Member " . $this->total_member . "<br>";
   echo "Total Guest " . $this->total_guest . "<br>";
   echo "User Terdaftar: $users <br>";


  }

  }
 ?>
