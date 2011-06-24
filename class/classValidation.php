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
	/*
	*
	 */
	abstract protected function draft();
	 /*
	 *
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
	public function setVendor($value) {
		$this->vendor = $value;

	}
	public function getVendor() {
		return $this->vendor;
	}
	public function setTableName($value) {
		$this->tableName = $value;

	}
	public function getTableName() {
		return $this->tableName;
	}
	public function setPrimaryKeyName($value) {
		$this->primaryKeyName = $value;

	}
	public function getPrimaryKeyName() {
		return $this->primaryKeyName;
	}

	/**
	 * Set All Religion Identification Array To Sql Statement
	 * @param string $value
	 */
	public function setPrimaryKeyAll($value){
		$this->primaryKeyAll= $value;
	}
	/**
	 * Return Religion Identification Array
	 * @return string $religionIdAll
	 */
	public function getPrimaryKeyAll() {
		return $this->primaryKeyAll;
	}
	/**
	 * Set Total Record of Table
	 * @param numeric $value
	 */
	public function setTotal($value){
		$this->total = $value;
	}

	/**
	 * Return Total Record of table
	 * @return numeric
	 */
	public function getTotal(){
		return $this->total;
	}

	/**
	 * Set isDefault Value
	 * @param boolean $value
	 */
	public function setIsDefault($value) {
		$this->isDefault = $value;
	}
	/**
	 * Return isDefault Value
	 * @return boolean isDefault
	 */
	public function getIsDefault() {
		return $this->isDefault;
	}

	/**
	 * Set isNew value
	 * @param boolean $value
	 */
	public function setIsNew($value) {
		$this->isNew = $value;
	}
	/**
	 * Return isNew value
	 * @return boolean isNew
	 */
	public function getIsNew() {
		return $this->isNew;
	}

	/**
	 * Set IsDraft Value
	 * @param boolean $value
	 */
	public function setIsDraft($value) {
		$this->isDraft = $value;
	}
	/**
	 * Return isDraftValue
	 * @return boolean isDraft
	 */
	public function getIsDraft() {
		return $this->isDraft;
	}

	/**
	 * Set isUpdate Value
	 * @param boolean $value
	 */
	public function setIsUpdate($value) {
		$this->isUpdate = $value;
	}
	/**
	 * Return isUpdate Value
	 * @return boolean isUpdate
	 */
	public function getIsUpdate() {
		return $this->isUpdate;
	}

	/**
	 * Set isActive Value
	 * @param boolean $value
	 */
	public function setIsActive($value) {
		$this->isActive = $value;
	}
	/**
	 * Return isActive value
	 * @return boolean isActive
	 */
	public function getIsActive() {
		return $this->isActive;
	}

	/**
	 * Set isDelete Value
	 * @param boolean $value
	 */
	public function setIsDelete($value) {
		$this->isDelete = $value;
	}
	/**
	 * Return isDelete Value
	 * @return boolean isDelete
	 */
	public function getIsDelete() {
		return $this->isDelete;
	}

	/**
	 * Set isApproved Value
	 * @param boolean $value
	 */
	public function setIsApproved($value) {
		$this->isApproved = $value;
	}
	/**
	 * Return isApproved Value
	 * @return boolean isApproved
	 */
	public function getIsApproved() {
		return $this->isApproved;
	}

	/**
	 * Set Activity User
	 * @param integet $value
	 */
	public function setBy($value) {
		$this->By = $value;
	}
	/**
	 * Get Activity User
	 * @return integer User
	 */
	public function getBy() {
		echo "dari getter".$this->By;
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
	 *  @return date Time Activity User
	 */
	public function getTime() {

		return $this->Time;
	}

}