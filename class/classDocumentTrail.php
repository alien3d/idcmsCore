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




	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create(){}
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
		/**
		 *	Define basic audit trail system...
		 * 	@params numeric $documentCategoryId = 3
		 **/
		$documentCategoryId =3;



		$this->q->start();

		if($this->getVendor()==self::mysql){
		$sql = "INSERT INTO `document`
								(
									`documentCategoryId`,
									`leafId`,
									`documentTitle`,
									`documentDesc`,
									`documentPath`,
									`documentFilename`,
									`isNew`,
									`isActive`,
									`executeBy`,
									`executeTime`
								)
						VALUES	(
									\"".$documentCategoryId."\",
									\"".$leafId."\",
									\"".$filename."\",
									\"".$path."\",
									\"".$filename."\",
									\"".$filename."\",
									'1',
									'1',
									\"".$_SESSION['staffId']."\",
									\"".date("Y-m-d H:i:s")."\"
								); ";
		} else if ($this->getVendor()==self::mssql){

		} else if ($this->getVendor()==self::oracle){

		}
		$this->q->create($sql);
		$this->q->commit();

		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}


	}
}