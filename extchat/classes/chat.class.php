<?php

require_once('session.class.php');
require_once('abstract.chat.class.php');

class Chat extends abstractchat {

	private $MySqlite;
	private $ses;

	function __construct($ses_id,$db){
	// connect to the database
		$this->MySqlite = $db;
		$this->ses = & new user_session($this->MySqlite,$ses_id);
	}

	public function __destruct(){
		//$this->MySqlite->close();
	}

	private function deleteMessages(){
	
		 $jumlah = $this->MySqlite->select_sql("select count(*) from chat");
		 if ($jumlah) {
		  $query = 'TRUNCATE TABLE chat';
		  $result = $this->MySqlite->exec_sql($query);
		 }
	}

	public function postMessage($name, $message){
		$message = $this->nohtml($message);
		$posted_on = date("j-m-Y H:i:s");
		$query = "INSERT INTO chat(posted_on, user_name, message) ";
		$query .= " VALUES ('$posted_on','$name','$message')";
		$result = $this->MySqlite->exec_sql($query);
	}

	public function retrieveNewMessages($id=0){
		$id = mysql_escape_string($id);
		if($id>0){
		$query =
			'SELECT chat_id, user_name, message,  ' .
			' posted_on' .
			' FROM chat WHERE chat_id > ' . $id .
			' ORDER BY chat_id ASC';
		}else{
		$query =
			' SELECT chat_id, user_name, message, posted_on FROM ' .
			' (SELECT chat_id, user_name, message, ' .
			' posted_on' .
			' FROM chat ' .
			' ORDER BY chat_id DESC ' .
			' LIMIT 1) AS Last50' .
			' ORDER BY chat_id ASC';
		}
		$result = $this->MySqlite->select_sql($query,GET_FIELD);
		$response = Array(); 
		$response['success'] = true; 
		$response ['clear'] = $this->isDatabaseCleared($id);
		$response['users'] = $this->getUsers(); 
		$_response = Array(); 
		if($result){
		foreach ($result as $row){
			$id = $row['chat_id'];
			$userName = $row['user_name'];
			$time = $row['posted_on'];
			$message = $this->smile($row['message']);
			$_r = Array(); 
			$_r['id'] = $id; 
			$_r['priv'] =false;
			$_r['userName'] = $userName; 
			$_r['time'] =$time; 
			$_r['message'] = $message;
			$_response[]= $_r; 
		}
		}
		$response['messages'] = $_response; 	 
		return json_encode($response);
	}

	private function isDatabaseCleared($id){
		if($id>0){
			$check_clear = 'SELECT count(*) old FROM chat where chat_id<=' . $id;
			$result = $this->MySqlite->select_sql($check_clear,GET_FIELD);
			if ($result)
				if($result[0]['old']==0)
			return true;
		}
		return false;
	}

	 private function getUsers() {
		  $this->ses->getSession(0.1);
		  $users = $this->ses->username;
		  $data = Array(); 
		  foreach($users as $user)
		    $data[]['user'] = $user;
		  return $data;
	 }

	 private function deleteMsg() {
	    $total = $this->ses->total_member;
	    if ($total==1)
	     $this->deleteMessages();
	
	 }

}
?>
