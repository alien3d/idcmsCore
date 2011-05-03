<?php
class validation {
	public function strict($v,$t) {
		$this->value	=	$v;
		$this->type		=	$t;

		// short form code available
		if($this->type=='password' || $this->type=='p') {
			if(strlen($this->value) != 32) {
				if(empty($this->value)) {
					return null;
				}
			}
			return(addslashes($this->value));

		}	elseif($this->type=='numeric' || $this->type=='n') {
			if(!is_numeric($this->value)) {
				$this->value=0;
				return($this->value);
			}	else {
				return(intval($this->value));
			}
		} 	elseif($this->type=='boolean' ||  $this->type=='b') {
			if($this->value == 'true') {
				return 1;
			} elseif($this->value) {
				return 0;
			}
		}	elseif($this->type=='string' || $this->type=='s') {
			if(empty($this->value) && (strlen($this->value) == 0)) {
				$this->value=null;
				return($this->value);
			}	elseif(strlen($this->value) ==0){
				$this->value= null;
				return($this->value);
			}	else {
				//UTF8 bugs
				//$this->value=trim(strtoupper($this->value)); // trim any space better for searching issue
				$this->value	= addslashes($this->value);
				return $this->value;
			}
		}	else if (
		($this->type=='email' || $this->type=='e') 		||
		($this->type=='filename' || $this->type=='f') 	||
		($this->type=='iconname' || $this->type=='i') 	||
		($this->type=='calendar' || $this->type=='c') 	||
		($this->type=='username' || $this->type=='u') 	||
		($this->type=='web' || $this->type=='wb')
		) {
			if(empty($this->value) && (strlen($this->value) == 0)) {
				$this->value=null;
				return($this->value);
			}	elseif(strlen($this->value) ==0){
				$this->value= null;
				return($this->value);
			}	else {
				$this->value=trim($this->value); // trim any space better for searching issue
				return $this->value;
			}

		}elseif($this->type=='wyswyg' || $this->type=='w') {

			// just return back
			// addslashes will destroy the code
			$this->value = addslashes($this->value);
			return(htmlspecialchars($this->value));
		}	elseif($this->type=='blob') {
			// this is easy for php/mysql developer

			$this->value=addslashes($this->value);
			return(htmlspecialchars($this->value));

		}	elseif($this->type=='memo' || $this->type=='m') {
			// this is easy for vb/access developer

			$this->value=addslashes($this->value);
			return(htmlspecialchars($this->value));

		}	elseif($this->type=='currency') {
			// make easier for vb.net programmer to understand float value

			$this->value=str_replace("$","",$this->value); // filter for extjs if exist
			$this->value=str_replace(",","",$this->value);
			return($this->value);

		}	elseif($this->type=='float' || $this->type=='f') {
			// make easier c programmer to understand float value
			$this->value=str_replace("$","",$this->value); // filter for extjs if exist
			$this->value=str_replace(",","",$this->value);
			return($this->value);

		}	elseif($this->type=='date' || $this->type=='d') {
			// ext date like this mm/dd yy03/03/07
			// ext date mm/dd/yy mysql date yyyymmdd
			//ext allready validate date at javascript runtime
			// check either the date empty or not if empty key in today value

			if(empty($this->value)) {
				return(date("Y-m-d"));
			}	else {
				$day=substr($this->value	,0,2);
				$month=substr($this->value	,3,2);
				$year=substr($this->value	,6,4);
				return($year."-".$month."-".$day);
			}
		}

	}
}