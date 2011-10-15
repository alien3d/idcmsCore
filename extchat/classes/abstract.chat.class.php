<?php

class abstractchat {
	var  $wpsmiliestrans; 
	
	function __construct(){
		$this->smilies_init();
	}
	function smilies_init() {
			$this->wpsmiliestrans = array(
			':mrgreen:' => 'icon_mrgreen.gif',
			':neutral:' => 'icon_neutral.gif',
			':twisted:' => 'icon_twisted.gif',
			  ':arrow:' => 'icon_arrow.gif',
			  ':shock:' => 'icon_eek.gif',
			  ':smile:' => 'icon_smile.gif',
				':???:' => 'icon_confused.gif',
			   ':cool:' => 'icon_cool.gif',
			   ':evil:' => 'icon_evil.gif',
			   ':grin:' => 'icon_biggrin.gif',
			   ':idea:' => 'icon_idea.gif',
			   ':oops:' => 'icon_redface.gif',
			   ':razz:' => 'icon_razz.gif',
			   ':roll:' => 'icon_rolleyes.gif',
			   ':wink:' => 'icon_wink.gif',
				':cry:' => 'icon_cry.gif',
				':eek:' => 'icon_surprised.gif',
				':lol:' => 'icon_lol.gif',
				':mad:' => 'icon_mad.gif',
				':sad:' => 'icon_sad.gif',
				  '8-)' => 'icon_cool.gif',
				  '8-O' => 'icon_eek.gif',
				  ':-(' => 'icon_sad.gif',
				  ':-)' => 'icon_smile.gif',
				  ':-?' => 'icon_confused.gif',
				  ':-D' => 'icon_biggrin.gif',
				  ':-P' => 'icon_razz.gif',
				  ':-o' => 'icon_surprised.gif',
				  ':-x' => 'icon_mad.gif',
				  ':-|' => 'icon_neutral.gif',
				  ';-)' => 'icon_wink.gif',
				   '8)' => 'icon_cool.gif',
				   '8O' => 'icon_eek.gif',
				   ':(' => 'icon_sad.gif',
				   ':)' => 'icon_smile.gif',
				   ':?' => 'icon_confused.gif',
				   ':D' => 'icon_biggrin.gif',
				   ':P' => 'icon_razz.gif',
				   ':o' => 'icon_surprised.gif',
				   ':x' => 'icon_mad.gif',
				   ':|' => 'icon_neutral.gif',
				   ';)' => 'icon_wink.gif',
				  ':!:' => 'icon_exclaim.gif',
				  ':?:' => 'icon_question.gif',
			);
	}
		
  function nohtml($string) {
  	$string = str_replace("'","\'",$string); 
    $string = htmlspecialchars($string); //agar kode html tidak diijinkan
    $string = str_replace("\n","<br>",$string); //merubah karakter enter jadi br  
     return($string);
  }
  
  function smile($text) {
  		$this->smilies_init();
		$output =$text;
		foreach($this->wpsmiliestrans as $key=>$value){
			$output = str_replace($key,"<img src='images/smilies/$value' title='$key'/>",$output); 
		}
		return $output;
  }
   
}

?>
