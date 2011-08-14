<?php
require_once("../../class/classValidation.php");
/**
 * this is leafUser model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package leafUser
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class languageModel extends validationClass
{
    public $tableName;
    public $primaryKeyName;
    public $leafUserId;
    public $leafId;
    public $leafSequence;
    public $staffId;

    private $test;
    // constant method if lazy
    const tableName = 'tableName';
    const primaryKeyName = 'primaryKeyName';
    const leafUserId = 'leafUserId';
    const leafUserDesc = 'leafUserDesc';
    const isDefaut = 'isDefault';
    const isNew = 'isNew';
    const isDraft = 'isDraft';
    const isUpdate = 'isUpdate';
    const isActive = 'isActive';
    const isDelete = 'isDelete';
    const isApproved = 'isApproved';
    const By = 'By';
    const Time = 'Time';
    const staffId = 'staffId';
    /* (non-PHPdoc)
     * @see validationClass::execute()
     */
    function execute()
    {
        /*
         *  Basic Information Table
         */
        $this->tableName      = 'leafUser';
        $this->primaryKeyName = 'leafUserId';
        /*
         * SET ALL OUTSIDE VARIABLE FROM POST OR GET OR PUT OR DELETE
		 * Restfull Format  POST 			-->Is to View Data
		 *                  GET  			-->Is to Receive Data
		 *                  PUT  			-->Is To Update Data
		 *                  DELETE/Destroy  -->Is To Delete/Destroy Data
         */
        if (isset($_POST['leafUserId'])) {
            $this->leafUserId = $this->strict($_POST['leafUserId'], 'numeric');
        }
        if (isset($_POST['leafUserDesc'])) {
            $this->leafUserDesc = $this->strict($_POST['leafUserDesc'], 'memo');
        }
        if (isset($_SESSION['staffId'])) {
            $this->By = $_SESSION['staffId'];
        }
        if ($this->vendor == 'normal' || $this->getVendor()==self::mysql) {
            $this->Time = "\"". date("Y-m-d H:i:s") . "\"";
        } else if ($this->getVendor()==self::mssql) {
            $this->Time = "\"". date("Y-m-d H:i:s") . "\"";
        } else if ($this->getVendor()==self::oracle) {
            $this->Time = "to_date(\"". date("Y-m-d H:i:s") . "\",'YYYY-MM-DD HH24:MI:SS')";
        }
    }
    /* (non-PHPdoc)
     * @see validationClass::create()
     */
    function create()
    {
        $this->isDefaut   = 0;
        $this->isNew      = 1;
        $this->isDraft    = 0;
        $this->isUpdate   = 0;
        $this->isActive   = 1;
        $this->isDelete   = 0;
        $this->isApproved = 0;
    }
    /* (non-PHPdoc)
     * @see validationClass::update()
     */
    function update()
    {
        $this->isDefaut   = 0;
        $this->isNew      = 0;
        $this->isDraft    = 0;
        $this->isUpdate   = 1;
        $this->isActive   = 1;
        $this->isDelete   = 0;
        $this->isApproved = 0;
    }
    /* (non-PHPdoc)
     * @see validationClass::delete()
     */
    function delete()
    {
        $this->isDefaut   = 0;
        $this->isNew      = 0;
        $this->isDraft    = 0;
        $this->isUpdate   = 0;
        $this->isActive   = 0;
        $this->isDelete   = 1;
        $this->isApproved = 0;
    }

    public function setIsDefault($value,$key,$type) {
		if($type=='single'){

			$this->isDefault = $value;
		} else if ($type=='array') {

			$this->isDefault[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isDefault Value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return boolean isDefault
	 */
	public function getIsDefault($key,$type) {
		if($type=='single'){
			return $this->isDefault;
		} else if ($type=='array'){

			return $this->isDefault[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set isNew value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsNew($value,$key,$type) {
		if($type=='single'){
			$this->isNew = $value;
		} else if ($type=='array'){
			$this->isNew[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isNew value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return boolean isNew
	 */
	public function getIsNew($key,$type) {
		if($type=='single'){
			return $this->isNew;
		} else if ($type=='array'){
			return $this->isNew[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set IsDraft Value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @param boolean $value
	 */
	public function setIsDraft($value,$key,$type) {
		if($type=='single'){
			$this->isDraft = $value;
		} elseif ($type=='array'){
			$this->isDraft[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isDraftValue
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return boolean isDraft
	 */
	public function getIsDraft($key,$type) {
		if($type=='single'){
			return $this->isDraft;
		} else if ($type=='array'){
			return $this->isDraft[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set isUpdate Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsUpdate($value,$key,$type) {
		if($type=='single'){
			$this->isUpdate = $value;
		} elseif ($type=='array'){
			$this->isUpdate[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isUpdate Value
	 * @return boolean isUpdate
	 */
	public function getIsUpdate($key,$type) {
		if($type=='single'){
			return $this->isUpdate;
		} else if ($type=='array'){
			return $this->isUpdate[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set isDelete Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsDelete($value,$key,$type) {
		if($type=='single'){
			$this->isDelete = $value;
		} elseif ($type=='array'){

			$this->isDelete[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}

	}
	/**
	 * Return isDelete Value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return boolean isDelete
	 */
	public function getIsDelete($key,$type) {
		if($type=='single'){

			return $this->isDelete;
		} else if ($type=='array'){

			return $this->isDelete[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set isActive Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsActive($value,$key,$type) {
		if($type=='single'){
			$this->isActive = $value;
		} elseif ($type=='array'){
			$this->isActive[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}

	}
	/**
	 * Return isActive value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return boolean isActive
	 */
	public function getIsActive($key,$type) {
		if($type=='single'){
			return $this->isActive;
		} else if ($type=='array'){
			return $this->isActive[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}



	/**
	 * Set isApproved Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIsApproved($value,$key,$type) {
		if($type=='single'){
			$this->isApproved = $value;
		} elseif ($type=='array'){
			$this->isApproved[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isApproved Value
	 * @param numeric $key  Array as value
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return boolean isApproved
	 */
	public function getIsApproved($key,$type) {
		if($type=='single'){
			return $this->isApproved;
		} else if ($type=='array'){
			return $this->isApproved[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set Activity User
	 * @param int $value
	 */
	public function setBy($value) {
		$this->isBy = $value;
	}
	/**
	 * Get Activity User
	 * @return integer User
	 */
	public function getBy() {
		return $this->isBy;
	}

	/**
	 * Set Time Activity User
	 * @param date $value
	 */
	public function setTime($value) {
		$this->isTime = $value;
	}
	/**
	 *  Return Time Activity User
	 *  @return date Time Activity User
	 */
	public function getTime() {
		return $this->isTime;
	}

}
?>