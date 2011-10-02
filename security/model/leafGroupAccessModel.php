<?php

require_once ("../../class/classValidation.php");

/**
 * this is leaf security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessModel extends validationClass {
	
	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $leafGroupAccessId;
	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $groupId;
	/**
	 * Module   Identification (** For Filtering  Only)
	 * @var bool
	 */
	private $moduleId;
	/**
	 * Folder   Identification (** For Filtering Only)
	 * @var int
	 */
	private $folderId;
	/**
	 * Leaf  Identification(** For Filtering only)
	 * @var int
	 */
	private $leafTempId;
	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Leaf Create Access Value
	 * @var bool
	 */
	private $leafAccessCreateValue;
	/**
	 * Leaf Read Access Value
	 * @var bool
	 */
	private $leafAccessReadValue;
	/**
	 * Leaf Update Access Value
	 * @var bool
	 */
	private $leafAccessUpdateValue;
	/**
	 * Leaf Delete Access Value
	 * @var bool
	 */
	private $leafAccessDeleteValue;
	/**
	 * Leaf Print Access Value
	 * @var bool
	 */
	private $leafAccessPrintValue;
	/**
	 * Leaf Posting Access Value
	 * @var bool
	 */
	private $leafAccessPostValue;
	
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/**
		 * Basic Information Table
		 */
		$this->setTableName ( 'leafGroupAccess' );
		$this->setPrimaryKeyName ( 'leafGroupAccessId' );
		/**
		 * All the $_POST enviroment.
		 */
		if (isset ( $_GET ['leafGroupAccessId'] )) {
			$this->setTotal ( count ( $_GET ['leafGroupAccessId'] ) );
		}
		if (isset ( $_POST ['groupId'] )) {
			$this->setGroupId ( $this->strict ( $_POST ['groupId'], 'numeric' ) );
		}
		if (isset ( $_POST ['moduleId'] )) {
			$this->setModuleId ( $this->strict ( $_POST ['moduleId'], 'numeric' ) );
		}
		if (isset ( $_POST ['folderId'] )) {
			$this->setFolderId ( $this->strict ( $_POST ['folderId'], 'numeric' ) );
		}
		if (isset ( $_POST ['staffId'] )) {
			$this->setStaffId ( $this->strict ( $_POST ['staffId'], 'numeric' ) );
		}
		if (isset ( $_SESSION ['staffId'] )) {
			$this->setExecuteBy ( $_SESSION ['staffId'] );
		}
		if ($this->getVendor () == self::mysql) {
			$this->setExecuteTime ( "\"" . date ( "Y-m-d H:i:s" ) . "\"" );
		} else if ($this->getVendor () == self::mssql) {
			$this->setExecuteTime ( "\"" . date ( "Y-m-d H:i:s" ) . "\"" );
		} else if ($this->getVendor () == self::oracle) {
			$this->setExecuteTime ( "to_date('" . date ( "Y-m-d H:i:s" ) . "','YYYY-MM-DD HH24:MI:SS')" );
		}
		
		for($i = 0; $i < $this->getTotal (); $i ++) {
			
			$this->setLeafGroupAccessId ( $this->strict ( $_GET ['leafGroupAccessId'] [$i], 'numeric' ), $i );
			
			if ($_GET ['leafAccessCreateValue'] [$i] == 'true') {
				$this->setleafAccessCreateValue ( $i, 1 );
			
			} else {
				$this->setleafAccessCreateValue ( $i, 0 );
			}
			
			if ($_GET ['leafAccessReadValue'] [$i] == 'true') {
				
				$this->setleafAccessReadValue ( $i, 1 );
			} else {
				
				$this->setleafAccessReadValue ( $i, 0 );
			}
			
			if ($_GET ['leafAccessUpdateValue'] [$i] == 'true') {
				
				$this->setleafAccessUpdateValue ( $i, 1 );
			} else {
				
				$this->setleafAccessUpdateValue ( $i, 0 );
			}
			
			if ($_GET ['leafAccessDeleteValue'] [$i] == 'true') {
				$this->setleafAccessDeleteValue ( $i, 1 );
			} else {
				$this->setleafAccessDeleteValue ( $i, 1 );
			}
			
			if ($_GET ['leafAccessPrintValue'] [$i] == 'true') {
				$this->setleafAccessPrintValue ( $i, 1 );
			} else {
				$this->setleafAccessPrintValue ( $i, 0 );
			}
			
			if ($_GET ['leafAccessPostValue'] [$i] == 'true') {
				$this->setleafAccessPostValue ( $i, 1 );
			} else {
				$this->setleafAccessPostValue ( $i, 0 );
			}
			if ($_GET ['leafAccessDraftValue'] [$i] == 'true') {
				$this->leafAccessDraftValue [$i] = 1;
				$this->setleafAccessDraftValue ( $i, 1 );
			} else {
				$this->leafAccessDraftValue [$i] = 0;
				$this->setleafAccessDraftValue ( $i, 0 );
			}
			$primaryKeyAll .= $this->getLeafGroupAccessId ( $i, 'array' ) . ",";
		
		}
		
		$this->setPrimaryKeyAll ( (substr ( $primaryKeyAll, 0, - 1 )) );
	
	}
	
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
	}
	
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {
	
	}
	
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
	}
	
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 1, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 1, 0, 'single' );
	}
	/**
	 * Set Leaf Group Access Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessId($value, $key, $type) {
		if ($type == 'single') {
			$this->leafGroupAccessId = $value;
		} else if ($type == 'array') {
			$this->leafGroupAccessId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:setLeafGroupAccessId ?" ) );
			exit ();
		}
	}
	/**
	 * Return Leaf Group Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLeafGroupAccessId($key, $type) {
		if ($type == 'single') {
			return $this->leafGroupAccessId;
		} else if ($type == 'array') {
			return $this->leafGroupAccessId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:getLeaGroupAccessId ?" ) );
			exit ();
		}
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafTempId($value) {
		$this->leafTempId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int
	 */
	public function getLeafTempId() {
		
		return $this->leafTempId;
	}
	
	/**
	 * Set Group Identification Value
	 * @param  int $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Group Identification Value
	 * @return int
	 */
	public function getGroupId() {
		
		return $this->groupId;
	}
	/**
	 * Set Leaf Create Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'e
	 */
	public function setleafAccessCreateValue($value, $key, $type) {
		$this->leafAccessCreateValue [$key] = $value;
	}
	/**
	 * Return Leaf Create Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessCreateValue($key, $type) {
		
		return $this->leafAccessCreateValue [$key];
	}
	
	/**
	 * Set Leaf Read Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setleafAccessReadValue($value, $key, $type) {
		$this->leafAccessReadValue [$key] = $value;
	}
	/**
	 * Return Leaf Read Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessReadValue($key, $type) {
		
		return $this->leafAccessReadValue [$key];
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setleafAccessUpdateValue($value, $key, $type) {
		$this->leafAccessUpdateValue [$key] = $value;
	}
	/**
	 * Return Leaf Update Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessUpdateValue($key, $type) {
		
		return $this->leafAccessUpdateValue [$key];
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setleafAccessDeleteValue($value, $key, $type) {
		$this->leafAccessUpdateValue [$key] = $value;
	}
	/**
	 * Return Leaf Delete Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessDeleteValue($key, $type) {
		
		return $this->leafAccessDeleteValue [$key];
	}
	/**
	 * Set Leaf Print Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setleafAccessPrintValue($value, $key, $type) {
		$this->leafAccessPrintValue [$key] = $value;
	}
	/**
	 * Return Leaf Print Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessPrintValue($key, $type) {
		
		return $this->leafAccessPrintValue [$key];
	}
	/**
	 * Set Leaf Post Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setleafAccessPostValue($value, $key, $type) {
		$this->leafAccessPostValue [$key] = $value;
	}
	/**
	 * Return Leaf Post  Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessPostValue($key, $type) {
		
		return $this->leafAccessPostValue [$key];
	}
	/**
	 * Set Leaf Draft Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setleafAccessDraftValue($value, $key, $type) {
		$this->leafAccessDraftValue [$key] = $value;
	}
	/**
	 * Return Leaf Draft Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafAccessDraftValue($key, $type) {
		
		return $this->leafAccessDraftValue [$key];
	}
	
	/**
	 * Set Module Identification Value
	 * @param  int $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;
	}
	/**
	 * Return Module Identification Value
	 * @return int
	 */
	public function getModuleId() {
		
		return $this->moduleId;
	}
	/**
	 * Set Folder Identification Value
	 * @param  int $value
	 */
	public function setFolderId($value) {
		$this->folderId = $value;
	}
	/**
	 * Return Folder Identification Value
	 * @return int
	 */
	public function getFolderId() {
		
		return $this->folderId;
	}
	/**
	 * Set Staff Identification Value
	 * @param  int $value
	 */
	public function setStaffId($value) {
		$this->staffId = $value;
	}
	/**
	 * Return Staff Identification Value
	 * @return int
	 */
	public function getStaffId() {
		
		return $this->staffId;
	}

}
?>