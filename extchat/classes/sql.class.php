<?php 

define('GET_FIELD',1);
define('GET_ROW',2);
define('GET_ALL',3);
/*
 @ sql lib by Ashadi
 @ last-update = 02-12-06 18:33
 @ Dokumentasi Method
 @ email : ashadi.cc@gmail.com
 =====================================================================
 method public

 1. set_koneksi = koneksikan ke mysql param : host,user,password,database

 2. select_sql($str, $type) = eksekusi sql yang mengembalikan result
    parameter= Str : string, Type : GET_ALL, GET_FIELD, GET_ROW
    return value = array()
 3. exec_sql($str)  = eksekusi sql yang tidak mengembalikan result
    parameter= Str : string
    return value = integer (>0 jika eksekusi sukses)
 4. GetRecord() = mengambil  record
 5. Display() = menampilkan record
 6. multi_query(str) : eksekusi lebih dari satu perintah sql dipisah dengan tanda petik koma(;)
    return value = 1 jika berhasil

 variable public
  row_count = jumlah baris
  field_count = jumlah kolom (field)
*/


class sql {
   var $mysql = null;
   var $record = array();
   var $result= null;
   var $type = GET_ALL;
   var $host = "localhost";
   var $pass = "";
   var $db = "";
   var $str = "";
   var $user = "root";
   var $affected_rows = 0;
   var $row_count= 0;
   var $field_count= 0;

   function sql() {
         //constructor
   }

   function set_koneksi($host,$user,$pass,$db) {
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->db = $db;
    $this->do_koneksi();
   }

   function do_koneksi() {
    //$this->mysql = & new mysqli($this->host,$this->user,$this->pass,$this->db) or die ("tidak bisa melakukan koneksi");
    $this->mysql = @mysql_connect($this->host,$this->user,$this->pass) or die("tidak bisa connect ke mysql"); 
    mysql_selectdb($this->db,$this->mysql) or die ('tidak bisa terhubung ke database');
   }

   function  select_sql($str,$type=GET_ALL) {
    $this->str = $str;
    $this->type = $type;
    $this->query_sql();
    $this->do_result();
    return $this->record;
   }

   function exec_sql($str){
   $this->str = $str;
   $this->query_sql();
    return $this->affected_rows;
   }

   function query_sql() {
      //$this->result = $this->mysql->query($this->str);
      $this->result = mysql_query($this->str,$this->mysql) or die(mysql_error()); 
   	 // if (!$this->result) die("error waktu eksekusi query : <b>$this->str<b>");
      $this->GetInfo();
   }

   function do_result() {
   $_data = array();
    while($_row = mysql_fetch_array($this->result,$this->type))
          $_data[] = $_row;
     $this->record = $_data;
     $this->row_count  = mysql_num_rows($this->result);
     //$this->result->close();
   }

   function getRecord() {
    return $this->record;
   }

   function Display() {
    $_row = $this->record;
    echo "<pre>\n";
    foreach ($_row as $col) {
     foreach ($col as $item=>$data)
      echo "$item    : $data\n";
      echo "<hr>\n";
    }
    echo "</pre>\n";
   }

   function GetInfo() {
    $this->affected_rows = mysql_affected_rows();   
    //$this->field_count   = mysql_field_len($this->result);


   }

   function multi_query($str) {
   //$status = $this->mysql->multi_query($str);
   return $status;

   }

   function __destruct() {
   mysql_close($this->mysql); 
   }

  }
 ?>