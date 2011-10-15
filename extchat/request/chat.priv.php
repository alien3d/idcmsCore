<?php
// reference the file containing the Chat class

require_once("../config.php");
require_once("../classes/chat.priv.class.php");
require_once ("../modules/fungsi.php");
session_start();
//session_register("username","usermode","ses_id");
$session_name = $_SESSION["username"] ;
// retrieve the operation to be performed
$mode = PostReq("mode");
$target = PostReq("name");
$session_id = "$session_name|$target";
// default the last id to 0
$id = 0;
// create a new Chat instance
$chat = new Chat_priv($session_id,$Con);
// if the operation is SendAndRetrieve
if($mode == 'SendAndRetrieveNew')
{
// retrieve the action parameters used to add a new message
$name = $_SESSION["username"];
$message = PostReq("message");
$id = PostReq("id");
// check if we have valid values
if ($name != '' && $message != '')
{
// post the message to the database

$chat->postMessage($name, $message, $color, $target);
}
}

// if the operation is Retrieve
elseif($mode == 'RetrieveNew')
{
// get the id of the last message retrieved by the client
$id = PostReq("id");
//$target= PostReq("name");
}


echo $chat->retrieveNewMessages($id,$target,PostReq('chatid'),PostReq('tabId'));
?>
