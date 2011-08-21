<?php
/**
 * Abstract Class Validation for Model Purpose.
 * @author hafizan
 *
 */
abstract class validationClass {
	// database property
	private $vendor;
	private $tableName;
	private $primaryKeyName;
	private $primaryKeyAll;
	private $total;

	// common field value
	private $isDefault;
	private $isNew;
	private $isDraft;
	private $isUpdate;
	private $isActive;
	private $isDelete;
	private $isApproved;
	private $By;
	private $Time;
	/*
	 * Mysql Database
	 * @var const string
	 */
	const mysql ='mysql';
	/**
	 * Microsoft Sql Server Database
	 * @var const string
	 */
	const mssql ='microsoft';
	/**
	 * Oracle Database
	 * @var const string
	 */
	const oracle = 'oracle';

	/**
	 *  Class Loader
	 */
	abstract protected function execute();
	/**
	 *  Outsite $_POST create record
	 */
	abstract protected function create();

	/**
	 * Outside $_POST update record
	 */
	abstract protected function update();
	/**
	 * Outside $_POST delete record
	 */
	abstract protected function delete();
	/**
	 * Outside $_POST delete record
	 */
	abstract protected function draft();

	/**
	 * Outside $_POST delete record
	 */
	abstract protected function approved();
	/**
	 * to filter data type.
	 * @param value $v
	 * value variable come from server request or variable
	 * @param type $t
	 * Available data type password or p ,
	 *                     numeric  or n,
	 *                     booleand or b,
	 *                     string   or s,
	 *                     wyswg    or w
	 *                     memo     or m,
	 *                     float    or f,
	 *                     date     or d
	 *                     username or u
	 *                     calender or
	 *                     web      or wb
	 *					  iconname   or i
	 * * @version 0.1 addd filter addslasshes
	 * @return NULL|string|Ambigous <NULL, number, value, string, mixed>|number|unknown
	 */

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
	/**
	 * Return Database Vendor
	 * @param string $value
	 */
	public function setVendor($value) {
		$this->vendor = $value;

	}

	/**
	 * Return Database Vendor
	 * @return string
	 */
	public function getVendor() {
		return $this->vendor;
	}
	/**
	 * Set Table Name
	 * @param string $value
	 */
	public function setTableName($value) {
		$this->tableName = $value;

	}
	/**
	 * Return Table Name
	 * @return string
	 */
	public function getTableName() {
		return $this->tableName;
	}
	/**
	 * Set Primary Name
	 * @param string $value
	 */
	public function setPrimaryKeyName($value) {
		$this->primaryKeyName = $value;

	}
	/**
	 * Return Primary Name
	 * @return string
	 */
	public function getPrimaryKeyName() {
		return $this->primaryKeyName;
	}

	/**
	 * Set Primary Key All
	 * @param string $value
	 */
	public function setPrimaryKeyAll($value){
		$this->primaryKeyAll= $value;
	}
	/**
	 * Return Primary Key All
	 * @return string
	 */
	public function getPrimaryKeyAll() {
		return $this->primaryKeyAll;
	}
	/**
	 * Set Total Record of Table
	 * @param  int $value
	 */
	public function setTotal($value){
		$this->total = $value;
	}

	/**
	 * Return Total Record of table
	 * @return int
	 */
	public function getTotal(){
		return $this->total;
	}

	/**
	 * Set isDefault Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'

	 */
	public function setIsDefault($value,$key,$type) {
		if($type=='single'){
			$this->isDefault = $value;
		} else if ($type=='array'){
			$this->isDefault[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsDefault ?"));
			exit();
		}
		
	}
	/**
	 * Return isDefault Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsDefault($key,$type) {
		if($type=='single'){
			return $this->isDefault;
		} else if ($type=='array'){
			return $this->isDefault[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsDefault ?"));
			exit();
		}

	}

	/**
	 * Set isNew value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsNew($value,$key,$type) {
		if($type=='single'){
			$this->isNew = $value;
		} else if ($type=='array'){
			$this->isNew[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsNew ?"));
			exit();
		}

	}
	/**
	 * Return isNew value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsNew($key,$type) {
		if($type=='single'){
			return $this->isNew;
		} else if ($type=='array'){
			return $this->isNew[$key];
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsNew ?"));
			exit();
		}

	}

	/**
	 * Set IsDraft Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsDraft($value,$key,$type) {
		if($type=='single'){
			$this->isDraft = $value;
		} else if ($type=='array'){
			$this->isDraft[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsDraft ?"));
			exit();
		}

	}
	/**
	 * Return isDraftValue
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsDraft($key,$type) {
		if($type=='single'){
			return $this->isDraft;
		} else if ($type=='array'){
			return $this->isDraft[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsDraft ?"));
			exit();
		}

	}

	/**
	 * Set isUpdate Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsUpdate($value,$key,$type) {
		if($type=='single'){
			$this->isUpdate = $value;
		} else if ($type=='array'){
			$this->isUpdate[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsUpdate ?"));
			exit();
		}

	}
	/**
	 * Return isUpdate Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsUpdate($key,$type) {
		if($type=='single'){
			return $this->isUpdate;
		} else if ($type=='array'){
			return $this->isUpdate[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsUpdate ?"));
			exit();
		}

	}

	/**
	 * Set isActive Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsActive($value,$key,$type) {
		if($type=='single'){
			$this->isActive = $value;
		} else if ($type=='array'){
			$this->isActive[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsActive ?"));
			exit();
		}

	}
	/**
	 * Return isActive value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsActive($key,$type) {
		if($type=='single'){
			return $this->isActive;
		} else if ($type=='array'){
			return $this->isActive[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsActive ?"));
			exit();
		}

	}

	/**
	 * Set isDelete Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsDelete($value,$key,$type) {
		if($type=='single'){
			$this->isDelete = $value;
		} else if ($type=='array'){
			$this->isDelete[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsDelete ?"));
			exit();
		}

	}
	/**
	 * Return isDelete Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsDelete($key,$type) {
		if($type=='single'){
			return $this->isDelete;
		} else if ($type=='array'){
			return $this->isDelete[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsDelete ?"));
			exit();
		}

	}

	/**
	 * Set isApproved Value
	 * @param bool $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsApproved($value,$key,$type) {
		if($type=='single'){
			$this->isApproved = $value;
		} else if ($type=='array'){
			$this->isApproved[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setIsApproved ?"));
			exit();
		}

	}
	/**
	 * Return isApproved Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getIsApproved($key,$type) {
		if($type=='single'){
			return $this->isApproved;
		} else if ($type=='array'){
			return $this->isApproved[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getIsApproved ?"));
			exit();
		}

	}

	/**
	 * Set Activity User
	 * @param int $value
	 */
	public function setBy($value) {
		$this->By = $value;
	}
	/**
	 * Get Activity User
	 * @return int
	 */
	public function getBy() {

		return $this->By;
	}

	/**
	 * Set Time Activity User
	 * @param date $value
	 */
	public function setTime($value) {
		$this->Time = $value;
	}
	/**
	 *  Return Time Activity User
	 *  @return date
	 */
	public function getTime() {

		return $this->Time;
	}

}