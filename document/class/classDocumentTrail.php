<?php
/**
 * Document Trail Audit.All Preprint Microsoft Excel Will Be Tracked
 * @author hafizan
 *
 */
class documentTrailClass extends configClass {
	/*
	 * Connection to the database
* @var string
	 */
	public $q;
	/*
	 *
	 */
	public $model;
	private $leafId;
	private $path;
	private $filename;
	/**
	 *	Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->model = new documentModel();

		$this->model->setVendor($this->getVendor());

		$this->model->execute();



	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create(){

		$this->model->create();
		/**
		 *	Define basic audit trail system...
		 * 	@params numeric $documentCategoryId = 3
		 **/
		$this->model->setDocumentCategoryId(3);
		$this->model->setLeafId($this->getLeafId());
		$this->model->setDocumentPath($this->getDocumentPath());
		$this->model->setDocumentFilename($this->getDocumentFilename());




		$this->q->start();

		if($this->getVendor()==self::mysql){
			$sql = "
			INSERT INTO `document`	(
						`documentCategoryId`,			`leafId`,
						`documentTitle`,				`documentDesc`,
						`documentPath`,					`documentFilename`,
						`isDefault`,					`isNew`,
						`isDraft`,						`isUpdate`,
						`isDelete`,						`isActive`,
						`isApproved`,					`By`,
						`Time`
			)	VALUES	(
						\"".$this->model->getDocumentCategoryId()."\",
						\"".$this->model->getLeafId()."\",
						\"".$this->model->getDocumentTitle()."\",
						\"".$this->model->getDocumentDesc()."\",
						\"".$this->model->getDocumentPath()."\",
						\"".$this->model->getDocumentFilename()."\",
						\"".$this->model->getIsDefault(0,'single')."\",
						\"".$this->model->getIsNew('','sring')."\",
						\"".$this->model->getIsDraft(0,'single')."\",
						\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete('','sring')."\",
						\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\",
						\"".$this->model->getBy()."\",
						 ".$this->model->getTime()."
			); ";
		} else if ($this->getVendor()==self::mssql){
			$sql = "
			INSERT INTO [document]	(
						[documentCategoryId],			[leafId],
						[documentTitle],				[documentDesc],
						[documentPath],					[documentFilename],
						[isDefault],					[isNew],
						[isDraft],						[isUpdate],
						[isDelete],						[isActive],
						[isApproved],					[By],
						[Time]
			)	VALUES	(
						\"".$this->model->getDocumentCategoryId()."\",
						\"".$this->model->getLeafId()."\",
						\"".$this->model->getDocumentTitle()."\",
						\"".$this->model->getDocumentDesc()."\",
						\"".$this->model->getPath()."\",
						\"".$this->model->getFilename()."\",
						\"".$this->model->getIsDefault(0,'single')."\",
						\"".$this->model->getIsNew('','sring')."\",
						\"".$this->model->getIsDraft(0,'single')."\",
						\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete('','sring')."\",
						\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\",
						\"".$this->model->getBy()."\",
						 ".$this->model->getTime()."
			); ";
		} else if ($this->getVendor()==self::oracle){
			$sql = "
			INSERT INTO \"document`	(
						\"documentCategoryId\",			\"leafId\",
						\"documentTitle\",				\"documentDesc\",
						\"documentPath\",				\"documentFilename\",
						\"isDefault\",					\"isNew\",
						\"isDraft\",					\"isUpdate\",
						\"isDelete\",					\"isActive\",
						\"isApproved\",					\"By\",
						\"Time\"
			)	VALUES	(
						\"".$this->model->getDocumentCategoryId()."\",
						\"".$this->model->getLeafId()."\",
						\"".$this->model->getDocumentTitle()."\",
						\"".$this->model->getDocumentDesc()."\",
						\"".$this->model->getPath()."\",
						\"".$this->model->getFilename()."\",
						\"".$this->model->getIsDefault(0,'single')."\",
						\"".$this->model->getIsNew('','sring')."\",
						\"".$this->model->getIsDraft(0,'single')."\",
						\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete('','sring')."\",
						\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\"\",
						\"".$this->model->getBy()."\",
						 ".$this->model->getTime()."
			); ";
		}
		$this->q->create($sql);
		$this->q->commit();

		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() {}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update(){}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete(){}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel(){}
	/**
	 * File Information
	 * @param string $filename
	 * @return mixed
	 */
	public function fileExtension($filename)
	{
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}

	/**
	 * Remove File Extension
	 * @param string $filename
	 * @return mixed
	 */
	public function removeExtension($filename) {
		return preg_replace('/(.+)\..*$/', '$1', $filename);
	}

	/**
	 * Document Audit Trail
	 * @param numeric $leafId
	 * @param string $path
	 * @param string $filename
	 */
	public function createTrail($leafId,$path,$filename){



	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int Document Cateogory Identification Value
	 */
	public function getLeafId() {
		return $this->leafId;
	}
/**
	 * Set Document Path Value
	 * @param boolean $value
	 */
	public function setDocumentPath($value) {
		$this->documentPath = $value;
	}
	/**
	 * Return Document title
	 * @return string document title
	 */
	public function getDocumentPath() {
		return $this->documentPath;
	}
	/**
	 * Set Document Filename Value
	 * @param boolean $value
	 */
	public function setDocumentFilename($value) {
		$this->documentFilename = $value;
	}
	/**
	 * Return Document Filename
	 * @return string document title
	 */
	public function getDocumentFilename() {
		return $this->documentFilename;
	}
}