<?php
require_once("../../class/classValidation.php");
/**
 * this is religion model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class religionModel extends validationClass
{
	// table property
	private $tableName;
	private $primaryKeyName;

	// table field
	private $religionId;
	private $religionDesc;
	private $isDefault;
	private $isNew;
	private $isDraft;
	private $isUpdate;
	private $isActive;
	private $isDelete;
	private $isApproved;
	private $By;
	private $Time;
	private $staffId;
	private $religionIdAll; // this is not table field but collection of religionId
	/**
	 * Total Record receive from checkbox grid
	 * @var numeric
	 */
	private $total;
	// database vendor
	public  $vendor;


	// table property
	const tableName = 'religion';
	const primaryKeyName = 'religionId';

	// table field
	const religionId = 'religionId';
	const religionDesc = 'religionDesc';
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
	public function execute()
	{
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('religion');
		$this->setPrimaryKeyName('religionId');
		/*
		 * SET ALL OUTSIDE VARIABLE FROM POST OR GET OR PUT OR DELETE
		 * Restfull Format  POST 			-->Is to View Data
		 *                  GET  			-->Is to Receive Data
		 *                  PUT  			-->Is To Update Data
		 *                  DELETE/Destroy  -->Is To Delete/Destroy Data
		 */
		if (isset($_POST['religionId'])) {
			$this->setReligionId($this->strict($_POST['religionId'], 'numeric'),'','string');
		}
		if (isset($_POST['religionDesc'])) {
			$this->setReligionDesc($this->strict($_POST['religionDesc'], 'memo'));
		}
		/**
		 *      Don't change below code
		 **/
		if (isset($_SESSION['staffId'])) {
			$this->setBy($_SESSION['staffId']);
		}
		if ($this->vendor == 'normal' || $this->vendor == 'mysql') {
			$this->setTime("\"". date("Y-m-d H:i:s") . "\"");
		} else if ($this->vendor == 'microsoft') {
			$this->setTime("\"". date("Y-m-d H:i:s") . "\"");
		} else if ($this->vendor == 'oracle') {
			$this->setTime("to_date(\"". date("Y-m-d H:i:s") . "\",'YYYY-MM-DD HH24:MI:SS')");
		}
		// updateStatus
	//	echo "Jumlah record ".count($_GET['religionId']);
		$this->setTotal(count($_GET['religionId']));
		$accessArray = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");
		// auto assign as array if true
		if(is_array($_GET['isDefault'])){
			$this->isDefault = array();
		}
		if(is_array($_GET['isNew'])){
			$this->isNew = array();
		}
		if(is_array($_GET['isDraft'])){
			$this->isDraft = array();
		}
		if(is_array($_GET['isUpdate'])){
			$this->isUpdate = array();
		}
		if(is_array($_GET['isDelete'])){
			$this->isDelete = array();
		}
		if(is_array($_GET['isActive'])){
			$this->isACtive = array();
		}
		if(is_array($_GET['isApproved'])){
			$this->isApproved = array();
		}
		for($i=0;$i<$this->getTotal();$i++) {
			echo "tepat daaa";
			$this->setReligionId($this->strict($_GET['religionId'][$i],'numeric'),$i,'array');
			if($_GET['isDefault'][$i]=='true') {

				$this->setIsDefault(1,$i,'array');
			} else if ($_GET['default']=='false'){

				$this->setIsDefault(0,$i,'array');
			}

			if($_GET['isNew'][$i]=='true') {

				$this->setIsNew(1,$i,'array');
			} else {

				$this->setIsNew(0,$i,'array');
			}

			if($_GET['isDraft'][$i]=='true') {

				$this->setIsDraft(1,$i,'array');
			} else {

				$this->setIsDraft(0,$i,'array');
			}

			if($_GET['isUpdate'][$i]=='true') {

				$this->setIsUpdate(1,$i,'array');
			} else {

				$this->setIsUpdate(0,$i,'array');
			}

			if($_GET['isDelete'][$i]=='true') {


				$this->setIsDelete(1,$i,'array');

			} else  if ($_GET['isDelete'][$i]=='false'){


				$this->setIsDelete(0,$i,'array');

			}


			if($_GET['isActive'][$i]=='true') {

				$this->setIsActive(1,$i,'array');
			} else {

				$this->setIsActive(0,$i,'array');
			}
			if($_GET['isApproved'][$i]=='true') {

				$this->setIsApproved(1,$i,'array');
			} else {

				$this->setIsApproved(0,$i,'array');
			}
			$religionIdAll.= $this->getReligionId($i,'array').",";
		}

		$this->setReligionIdAll(substr($religionIdAll,0,-1));
	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(1,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(0,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(1,'','string');
		$this->setIsActive(1,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(0,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		if(!(is_array($_GET['isDelete']))){

			$this->setIsDelete(1,'','string');
		}

		$this->setIsApproved(0,'','string');
	}
	/**
	 * Update Religion Table Status
	 */
	public function updateStatus() {
		if(!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,'','string');
		}
		if(!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,'','string');
		}
		if(!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,'','string');
		}
		if(!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,'','string');
		}
		if(!(is_array($_GET['isDelete']))) {

			$this->setIsDelete(1,'','string');
		}
		if(!(is_array($_GET['isActive']))) {
			$this->setIsActive(0,'','string');
		}

		if(!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,'','string');
		}
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
	// generate basic information from outside
	/**
	 * Set isDefault Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setReligionId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->religionId = $value;
		} else if ($type=='array'){
			$this->religionId[$key]=$value;
		}
	}
	/**
	 * Return isReligionId Value
	 * @return integer religionId
	 */
	public function getReligionId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->religionId;
		} else if ($type=='array'){
			return $this->religionId[$key];
		}
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 */
	public function setReligionDesc($value) {
		$this->religionDesc = $value;
	}
	/**
	 * Return Religion Description
	 * @return string religion description
	 */
	public function getReligionDesc() {
		return $this->religionDesc;
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsDefault($value,$key=NULL,$type=NULL) {
		if($type=='string'){

			$this->isDefault = $value;
		} else if ($type=='array') {

			$this->isDefault[$key]=$value;
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Return isDefault Value
	 * @param numeric $key  Array as value
	 *  @param enum   $type   1->string,2->array
	 * @return boolean isDefault
	 */
	public function getIsDefault($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isDefault;
		} else if ($type=='array'){

			return $this->isDefault[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}

	/**
	 * Set isNew value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsNew($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isNew = $value;
		} else if ($type=='array'){
			$this->isNew[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Return isNew value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isNew
	 */
	public function getIsNew($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isNew;
		} else if ($type=='array'){
			return $this->isNew[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}

	/**
	 * Set IsDraft Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @param boolean $value
	 */
	public function setIsDraft($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDraft = $value;
		} elseif ($type=='array'){
			$this->isDraft[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Return isDraftValue
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isDraft
	 */
	public function getIsDraft($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isDraft;
		} else if ($type=='array'){
			return $this->isDraft[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}

	/**
	 * Set isUpdate Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsUpdate($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isUpdate = $value;
		} elseif ($type=='array'){
			$this->isUpdate[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Return isUpdate Value
	 * @return boolean isUpdate
	 */
	public function getIsUpdate($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isUpdate;
		} else if ($type=='array'){
			return $this->isUpdate[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Set isDelete Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsDelete($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDelete = $value;
		} elseif ($type=='array'){

			$this->isDelete[$key]=$value;
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}

	}
	/**
	 * Return isDelete Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isDelete
	 */
	public function getIsDelete($key=NULL,$type=NULL) {
		if($type=='string'){

			return $this->isDelete;
		} else if ($type=='array'){

			return $this->isDelete[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Set isActive Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsActive($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isActive = $value;
		} elseif ($type=='array'){
			$this->isActive[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Return isActive value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isActive
	 */
	public function getIsActive($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isActive;
		} else if ($type=='array'){
			return $this->isActive[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}



	/**
	 * Set isApproved Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsApproved($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isApproved = $value;
		} elseif ($type=='array'){
			$this->isApproved[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}
	/**
	 * Return isApproved Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isApproved
	 */
	public function getIsApproved($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isApproved;
		} else if ($type=='array'){
			return $this->isApproved[$key];
		} else {
			echo "Cannot Identifiy Type";
			exit();
		}
	}

	/**
	 * Set Activity User
	 * @param integer $value
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

	/**
	 * Set All Religion Identification Array To Sql Statement
	 * @param string $value
	 */
	public function setReligionIdAll($value){
		$this->religionIdAll= $value;
	}
	/**
	 * Return Religion Id
	 * @return string $religionIdAll
	 */
	public function getReligionIdAll() {
		return $this->religionIdAll;
	}
	public function setTotal($value){
		$this->total = $value;
	}
	public function getTotal(){
		return $this->total;
	}
}
?>
