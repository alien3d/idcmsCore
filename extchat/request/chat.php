<?php
	require_once("../config.php");
	require_once("../classes/chat.class.php");
	require_once ("../modules/fungsi.php");
	session_start();
	$session_id = $_SESSION["ses_id"] ;
	$mode = PostReq("mode");
	$id = 0;
	$chat = new Chat($session_id,$Con);
	if($mode == 'SendAndRetrieveNew'){
		$name = $_SESSION["username"];
		$message = PostReq("message");
		$id = PostReq("id");
		if ($name != '' && $message != ''){
			$chat->postMessage($name, $message);
		}
	}elseif($mode == 'RetrieveNew'){
		$id = PostReq("id");
	}
	
	echo $chat->retrieveNewMessages($id);
?>
