<?php
// load configuration file
require_once('session.class.php');
require_once('abstract.chat.class.php');
// class that contains server-side chat functionality
class Chat_priv extends abstractchat {
	private $MySqlite;
	private $ses;

	function __construct($ses_id,$db){	
		$this->MySqlite = $db;
		$this->ses = & new user_session($this->MySqlite,$ses_id,"tpriv_session");
		$this->ses->getSession(0.1);
	}

	public function __destruct(){
	//$this->MySqlite->close();
	}

	public function deleteMessages(){
		$jumlah = $this->MySqlite->select_sql("select count(*) from chat_priv");
		 if ($jumlah) {
		  $query = 'TRUNCATE TABLE chat_priv';
		  $result = $this->MySqlite->exec_sql($query);
		 }
	}

	public function postMessage($name, $message, $color,$target){
		$message = $this->nohtml($message);
		$posted_on = date("j-m-Y H:i:s");
		
		$query = "INSERT INTO chat_priv(posted_on, user_name, message, color, target) ";
		$query .= " VALUES ('$posted_on','$name','$message','$color','$target')";
		
		$result = $this->MySqlite->exec_sql($query);
		$this->sendPopup($target,$name);
	}

	public function retrieveNewMessages($id=0,$target,$chatid,$tabId){
	
		$sender = $_SESSION["username"];
		//$id = mysql_escape_string($id);
		$aku = mysql_escape_string($sender);
		$kamu = mysql_escape_string($target);
		
		if($id>0)
		{
		// retrieve messages newer than $id
		$query ="SELECT chat_id, user_name, message, color, posted_on, target";
		$query .= " FROM chat_priv WHERE chat_id > '$id'";
		$query .= " AND ((user_name LIKE '$sender' AND target LIKE '$target')";
		$query .= " OR (user_name LIKE '$target' AND target LIKE '$sender'))";
		$query .= " ORDER BY chat_id ASC";
		
		}
		else
		{
		// on the first load only retrieve the last 50 messages from server
		$query = "SELECT chat_id, user_name, message, color, posted_on, target FROM "; 
		$query .= " chat_priv WHERE";
		$query .= "  (user_name LIKE '$sender' AND target LIKE '$target')";
		$query .= " OR (user_name LIKE '$target' AND target LIKE '$sender')";
		$query .= " ORDER BY chat_id desc LIMIT 0,1";
		
		}
		$result = $this->MySqlite->select_sql($query,GET_FIELD);
		$response = Array(); 
		$response['success'] = true; 
		$response['target'] = $target;
		$response['tabId'] = $tabId;
		$response ['clear'] = $this->isDatabaseCleared($id);
		$_response = Array(); 
		if($result){
		foreach ($result as $row){
			$id = $row['chat_id'];
			$userName = $row['user_name'];
			$time = $row['posted_on'];
			$message = $this->smile($row['message']);
			$_r = Array(); 
			$_r['id'] = $id; 
			$_r['priv'] =true;
			$_r['chatid']=$chatid;
			$_r['userName'] = $userName; 
			$_r['time'] =$time; 
			$_r['target'] = $target;
			$_r['message'] = $message;
			$_response[]= $_r; 
		}
		if ($this->serverMessage($target,$id,$chatid,$target)){
			$_response = Array();
			$_response[] = $this->serverMessage($target,$id,$chatid,$target);
		}
		}
	 	$response['messages'] = $_response; 
		return json_encode($response);
	
	}
	private function isDatabaseCleared($id){
		if($id>0){
			$check_clear = 'SELECT count(*) old FROM chat_priv where chat_id<=' . $id;
			$result = $this->MySqlite->select_sql($check_clear,GET_FIELD);
			if ($result)
				if($result[0]['old']==0)
			return true;
		}
		return false;
	}

	 private function sendPopup($target,$name) {
		  $sesid= "$target|$name";
		  $str = "select session_username from tpriv_session where session_id like '$sesid'";
		  $result =  $this->MySqlite->select_sql($str);
		  if (!$result) {
		    $posted_on = date("j-m-Y H:i:s");
			$sender = $_SESSION["username"];
			$goto = "$target|$sender";
			$str = "insert into chat (posted_on,user_name,message) values ";
			$str .= " ('$posted_on','$goto','_priv_chat_1209')";
			$result =  $this->MySqlite->exec_sql($str);
		  }
	 }
	 private function serverMessage($target,$id,$chatid,$target) {
	 	 $myrespon = "";
	 	 $ses_time = time();
	 	 $ses_time = $ses_time - 6;
	 	 $str1 = "select session_username from tpriv_session where session_username like '$target' and session_time > '$ses_time'";
	 	 $str2 = "select session_username from tuser_session where session_username like '$target' and session_time > '$ses_time'";
	 	 $result1 = $this->MySqlite->select_sql($str1);
	 	 $result2 = $this->MySqlite->select_sql($str2);
	 	 $kondisi = ($result1 || $result2)? true : false;
	 	 $_r = Array();
	 	 if (!$kondisi) {
	 	 	  $myid = $id++;
	  	 	$_r['id'] = $myid; 
			$_r['userName'] = 'Server Notice'; 
			$_r['priv'] =true;			
			$_r['time'] ='Peringatan'; 
			$_r['chatid']=$chatid;
			$_r['target'] = $target;
			$_r['message'] = "$target sudah keluar dari Chatt";
	
	 	 }
	 	 return $_r;
	 }

}
?>
