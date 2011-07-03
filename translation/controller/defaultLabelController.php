<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/defaultLabelModel.php");

/**
 * this defaultLabel menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package defaultLabel
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class defaultLabelClass extends  configClass {
	/*
	 * Connection to the database
	 * @var string $excel
	 */
	public $q;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
	 */
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private $documentTrail;
	/**
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var unknown_type
	 */
	private $log;
	/**
	 * department Model
	 * @var string $departmentModel
	 */
	public $model;
	/**
	 * Audit Filter
	 * @var string $auditFilter
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string $auditColumn
	 */
	public $auditColumn;
	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;

	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;
	/**
	 * defaultLabel Translation Identification
	 * @var  numeric $defaultLabelTranslateId
	 */
	public $defaultLabelTranslateId;
	/**
	 * Translation update
	 * @var string $defaultLabelTranslate
	 */
	public $defaultLabelTranslate;
	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		$this->q->fieldQuery 		= 	$this->getFieldQuery();

		$this->q->gridQuery			=	$this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;

		$this->defaultLanguageId  	= 21;

		$this->security 	= 	new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();

		$this->model = new defaultLabelModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();



	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->create();
		if($this->getVendor() == self::mysql) {
			$sql="
			INSERT INTO `defaultLabel`
					(
						`defautlLabel`,							`defaultlabelEnglish`
						`isDefault`,							`isNew`,
						`isDraft`,								`isUpdate`,
						`isDelete`,								`isActive`,
						`isApproved`,							`By`,
						`Time`
					)
			VALUES
					(
						\"".$this->model->getDefaultLabel()."\",						\"".$this->model->getDefaultLabelEnglish()."\"
						\"". $this->model->getIsDefault('','single') . "\",				\"". $this->model->getIsNew('','single') . "\",
						\"". $this->model->getIsDraft('','single') . "\",				\"". $this->model->getIsUpdate('','single') . "\",
						\"". $this->model->getIsDelete('','single') . "\",				\"". $this->model->getIsActive('','single') . "\",
						\"". $this->model->getIsApproved('','single') . "\",			\"". $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		}else if ($this->getVendor()==self::mssql) {
			$sql="
			INSERT INTO [defaultLabel]
					(
						[defaultLabel],							[defaultLabelEnglish]
						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[By],								[Time]
				)
			VALUES
				(
						\"".$this->model->getDefaultLabel()."\",						\"".$this->model->getDefaultLabelEnglish()."\"
						\"". $this->model->getIsDefault('','single') . "\",				\"". $this->model->getIsNew('','single') . "\",
						\"". $this->model->getIsDraft('','single') . "\",				\"". $this->model->getIsUpdate('','single') . "\",
						\"". $this->model->getIsDelete('','single') . "\",				\"". $this->model->getIsActive('','single') . "\",
						\"". $this->model->getIsApproved('','single') . "\",			\"". $this->model->getBy() . "\",
						" . $this->model->getTime() . "
			);";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			INSERT INTO 	\"defaultLabel\"
						(
							\"defaultLabel\",							\"defaultLabelEnglish\",
							\"isDefault\",								\"isNew\",
							\"isDraft\",								\"isUpdate\",
							\"isDelete\",								\"isActive\",
							\"isApproved\",								\"By\",
							\"Time\"
				VALUES	(
							\"".$this->model->getDefaultLabel()."\",						\"".$this->model->getDefaultLabelEnglish()."\"
							\"". $this->model->getIsDefault('','single') . "\",				\"". $this->model->getIsNew('','single') . "\",
							\"". $this->model->getIsDraft('','single') . "\",				\"". $this->model->getIsUpdate('','single') . "\",
							\"". $this->model->getIsDelete('','single') . "\",				\"". $this->model->getIsActive('','single') . "\",
							\"". $this->model->getIsApproved('','single') . "\",			\"". $this->model->getBy() . "\",
							" . $this->model->getTime() . "
			)";
		}
		$this->q->create($sql);
		if($this->q->execute=='fail') {
			echo json_encode(
			array(
					  	"success"	=>	false,

						"message"	=>	$this->q->responce
			));
			exit();
		}

		$lastId    = $this->q->lastInsertId();

		$this->q->commit();
		echo json_encode(array("success"=>true,"defaultLabelId"=>$lastId,"message"=>"Record Created"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 							{
		header('Content-Type','application/json; charset=utf-8');

		//UTF8
		$items=array();
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		// everything given flexibility  on todo
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT 		*
			FROM 		`defaultLabel`
			WHERE 1 ";
			if($this->model->getDefaultLabelId('','single')) {
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"".$this->model->getdefaultLabelId('','single')."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql	=	"
			SELECT 		*
			FROM 		[defaultLabel]
			WHERE 1 ";
			if($this->model->getDefaultLabelId('','single')) {
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"".$this->model->getdefaultLabelId('','single')."\"";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql	=	"
			SELECT 		*
			FROM 		\"defaultLabel\"
			WHERE 1";
			if($this->model->getDefaultLabelId('','single')) {
				$sql.=" AND \"".$this->model->getTableName()."`.".$this->model->getPrimaryKeyName()."\"=\"".$this->model->getdefaultLabelId('','single')."\"";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray =array('defaultLabelId');
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('defaultLabel');

	 if ($this->getFieldQuery()) {
	 	if ($this->getVendor() == self::mysql) {
	 		$sql .= $this->q->quickSearch($tableArray, $filterArray);
	 	} else if ($this->getVendor() == self::mssql) {
	 		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
	 		$sql .= $tempSql;
	 	} else if ($this->getVendor() == self::oracle) {
	 		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
	 		$sql .= $tempSql;
	 	}
	 }
	 /**
	  *	Extjs filtering mode
	  */
	 if ($this->getGridQuery()) {

	 	if ($this->getVendor() == self::mysql) {
	 		$sql .= $this->q->searching();
	 	} else if ($this->getVendor() == self::mssql) {
	 		$tempSql2 = $this->q->searching();
	 		$sql .= $tempSql2;
	 	} else if ($this->getVendor() == self::oracle) {
	 		$tempSql2 = $this->q->searching();
	 		$sql .= $tempSql2;
	 	}
	 }
		//echo $sql;
		$this->q->read($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$total	= $this->q->numberRows();

		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::oracle) {
				$sql .= "	ORDER BY \"" . $this->getSortField() . "\"  " . $this->getOrder() . " ";
			}
		}
		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$_POST['start'];
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($_POST['start']) && isset($_POST['limit'])) {
				// only mysql have limit

				if($this->getVendor() == self::mysql) {
					$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
					$sqlLimit = $sql;
				} else if ($this->getVendor()==self::mssql) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 */
					$sqlLimit="
							WITH [defaultLabelDerived] AS
							(
								SELECT	*,
								[defaultLabel].[By],
								[defaultLabel].[Time]
								ROW_NUMBER() OVER (ORDER BY [defaultLabelId]) AS 'RowNumber'
								FROM 		[defaultLabel]
								WHERE	1  ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[defaultLabelDerived]
							WHERE 		[RowNumber]
							BETWEEN	".$_POST['start']."
							AND 			".($_POST['start']+$_POST['limit']-1).";";


				}  else if ($this->getVendor()==self::oracle) {
					/**
					 *  Oracle using derived table also
					 */


					$sql="
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*
									FROM 		\"defaultLabel\"
									WHERE		1
									AND 		".$tempSql.$tempSql2.$orderBy."
								 ) a
						where rownum <= \"".($_POST['start']+$_POST['limit']-1)."\" )
						where r >=  \"".$_POST['start']."\"";

				} else {
					echo "undefine vendor";
				}
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if(!($this->model->getDefaultLabelId('','single'))) {

			$this->q->read($sql);
			if($this->q->execute=='fail') {
				echo json_encode(
				array(
					  	"success"	=>	false,
						"message"	=>	$this->q->responce
				));
				exit();
			}
		}
		$items 			= 	array();
		while($row  	= 	$this->q->fetchAssoc()) {
			$items[]	=	$row;
		}



		if($this->model->getDefaultlabelId('','single')) {
			$json_encode = json_encode(
			array(
						'success'	=>	true,
						'total' 	=> 	$total,
						'data' 		=> 	$items
			));
			$json_encode=str_replace("[","",$json_encode);
			$json_encode=str_replace("]","",$json_encode);
			echo $json_encode;
		} else {
			if(count($items)==0) {
				$items='';
			}
			echo json_encode(
			array(
											'success'	=>	true,
											'total' 	=> 	$total,
											'data' 		=> 	$items
			)
			);
			exit();
		}



	}



	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->update();
		if($this->getVendor() == self::mysql) {
			$sql="
					UPDATE 	`defaultLabel`
					SET 	`defaultLabelNote`		=	\"".$this->model->getDefaultLabelNote()."\",
							`defaultLabelEnglish`	=	\"".$this->model->getDefaultLabelEnglish()."\",
							`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
							`isActive`		=	\"".$this->model->getIsActive('','single')."\",
							`isNew`			=	\"".$this->model->getIsNew('','single')."\",
							`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
							`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
							`isDelete`		=	\"".$this->model->getIsDelete('','single')."\",
							`isApproved`	=	\"".$this->model->getIsApproved('','single')."\",
							`By`			=	\"".$this->model->getBy()."\",
							`Time`			=	".$this->model->getTime()."
					WHERE 	`defaultLabelId`			=	\"".$this->model->getDefaultLabelId('','single')."\"";
		}  else if ( $this->getVendor()==self::mssql) {
			$sql="
					UPDATE 	[defaultLabel]
					SET 	[defaultLabelNote]		=	\"".$this->model->getDefaultLabelNote()."\",
							[defaultLabelEnglish]	=	\"".$this->model->getDefaultLabelEnglish()."\",
							[isDefault]		=	\"".$this->model->getIsDefault('','single')."\",
							[isActive]		=	\"".$this->model->getIsActive('','single')."\",
							[isNew]			=	\"".$this->model->getIsNew('','single')."\",
							[isDraft]		=	\"".$this->model->getIsDraft('','single')."\",
							[isUpdate]		=	\"".$this->model->getIsUpdate('','single')."\",
							[isDelete]		=	\"".$this->model->getIsDelete('','single')."\",
							[isApproved]	=	\"".$this->model->getIsApproved('','single')."\",
							[By]			=	\"".$this->model->getBy()."\",
							[Time]			=	".$this->model->getTime()."
					WHERE 	[defaultLabelId]			=	\"".$this->model->getDefaultLabelId('','single')."\"";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE 	\"defaultLabel\"
					SET 	\"defaultLabelNote\"		=	\"".$this->model->getDefaultLabelNote()."\",
							\"defaultLabelEnglish\"	=	\"".$this->model->getDefaultLabelEnglish()."\",
							\"isDefault\"	=	\"".$this->model->getIsDefault('','single')."\",
							\"isActive\"	=	\"".$this->model->getIsActive('','single')."\",
							\"isNew\"		=	\"".$this->model->getIsNew('','single')."\",
							\"isDraft\"		=	\"".$this->model->getIsDraft('','single')."\",
							\"isUpdate\"	=	\"".$this->model->getIsUpdate('','single')."\",
							\"isDelete\"	=	\"".$this->model->getIsDelete('','single')."\",
							\"isApproved\"	=	\"".$this->model->getIsApproved('','single')."\",
							\"By\"			=	\"".$this->model->getBy()."\",
							\"Time\"		=	".$this->model->getTime()."
					WHERE 	\"defaultLabelId\"		=	\"".$this->model->getDefaultLabelId('','single')."\"";
		}
		$this->q->update($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>true,"message"=>"Record Update"));
		exit();


	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->delete();
		if($this->getVendor() == self::mysql) {
			$sql="
					UPDATE	`defaultLabel`
					SET		`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
							`isActive`		=	\"".$this->model->getIsActive('','single')."\",
							`isNew`			=	\"".$this->model->getIsNew('','single')."\",
							`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
							`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
							`isDelete`		=	\"".$this->model->getIsDelete('','single')."\",
							`isApproved`	=	\"".$this->model->getIsApproved('','single')."\",
							`By`			=	\"".$this->model->getBy()."\",
							`Time`			=	".$this->model->getTime()."
					WHERE 	`defaultLabelId`		=	\"".$this->model->getdefaultLabelId()."\"";

		} else if ($this->getVendor()==self::mssql) {
			$sql="
					UPDATE	[defaultLabel]
					SET		[isDefault]		=	\"".$this->model->getIsDefault('','single')."\",
							[isActive]		=	\"".$this->model->getIsActive('','single')."\",
							[isNew]			=	\"".$this->model->getIsNew('','single')."\",
							[isDraft]		=	\"".$this->model->getIsDraft('','single')."\",
							[isUpdate]		=	\"".$this->model->getIsUpdate('','single')."\",
							[isDelete]		=	\"".$this->model->getIsDelete('','single')."\",
							[isApproved]	=	\"".$this->model->getIsApproved('','single')."\",
							[By]			=	\"".$this->model->getBy()."\",
							[Time]			=	".$this->model->getTime()."
					WHERE 	[defaultLabelId]		=	\"".$this->model->getdefaultLabelId()."\"";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE	\"defaultLabel\"
					SET		\"isDefault\"	=	\"".$this->model->getIsDefault('','single')."\",
							\"isActive\"	=	\"".$this->model->getIsActive('','single')."\",
							\"isNew\"		=	\"".$this->model->getIsNew('','single')."\",
							\"isDraft\"		=	\"".$this->model->getIsDraft('','single')."\",
							\"isUpdate\"	=	\"".$this->model->getIsUpdate('','single')."\",
							\"isDelete\"	=	\"".$this->model->getIsDelete('','single')."\",
							\"isApproved\"	=	\"".$this->model->getIsApproved('','single')."\",
							\"By\"			=	\"".$this->model->getBy()."\",
							\"Time\"		=	".$this->model->getTime()."
					WHERE 	\"defaultLabelId\"	=	\"".$this->model->getdefaultLabelId()."\"";
		}
		$this->q->update($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Removed"));
		exit();


	}

	/**
	 *  To Update flag Status
	 */
	function updateStatus () {
		$this->model-> updateStatus();
		$loop  = $this->model->getTotal();

		if($this->isAdmin==0){

			$this->model->delete();
			if ($this->getVendor() == self::mysql) {
				$sql = "
				UPDATE 	`".$this->model->getTableName()."`
				SET 	";

				$sql.="	   `isDefault`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsDefault('','single')."\"";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsNew('','single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsDraft('','single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsUpdate('','single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsDelete($i,'array')."\"";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsActive('','single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDepartmentId($i,'array')."\"
						THEN \"".$this->model->getIsApproved('','single')."\"";

					}
				}
				$sql.="
				END,
				`By`				=	\"". $this->model->getBy() . "\",
				`Time`				=	" . $this->model->getTime() . " ";


				$this->model->setPrimaryKeyAll(substr($primaryKeyAll,0,-1));
				$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getPrimaryKeyAll(). ")";

			} else if ($this->getVendor() ==  self::mssql) {
				$sql = "
			UPDATE 	[Department]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault('','single') . "\",
					[isNew]				=	\"". $this->model->getIsNew('','single') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft('','single') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate('','single') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete('','single') . "\",
					[isActive]			=	\"". $this->model->getIsActive('','single') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved('','single') . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[DepartmentId]		IN	(". $this->model->getDepartmentIdAll() . ")";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				UPDATE	\"Department\"
				SET 	\"isDefault\"		=	\"". $this->model->getIsDefault('','single') . "\",
					\"isNew\"			=	\"". $this->model->getIsNew('','single') . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft('','single') . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate('','single') . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete('','single') . "\",
					\"isActive\"		=	\"". $this->model->getIsActive('','single') . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved('','single') . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"DepartmentId\"		IN	(". $this->model->getDepartmentIdAll() . ")";
			}
		} else if ($this->isAdmin ==1){

			if($this->getVendor() == self::mysql) {
				$sql="
				UPDATE `".$this->model->getTableName()."`
				SET";
			} else if($this->getVendor()==self::mssql) {
				$sql="
			UPDATE 	[".$this->model->getTableName()."]
			SET 	";

			} else if ($this->getVendor()==self::oracle) {
				$sql="
			UPDATE \"".$this->model->getTableName()."\"
			SET    ";
			}
			//	echo "arnab[".$this->model->getDepartmentId(0,'array')."]";
			/**
			 *	System Validation Checking
			 *  @var $access
			 */
			$access  = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");
			foreach($access as $systemCheck) {


				if($this->getVendor() == self::mysql) {
					$sqlLooping.=" `".$systemCheck."` = CASE `".$this->model->getPrimaryKeyName()."`";
				} else if($this->getVendor()==self::mssql) {
					$sqlLooping.="  [".$systemCheck."] = CASE [".$this->model->getPrimaryKeyName()."]";

				} else if ($this->getVendor()==self::oracle) {
					$sqlLooping.="	\"".$systemCheck."\" = CASE \"".$this->model->getPrimaryKeyName()."\"";
				}
				switch ($systemCheck){
					case 'isDefault':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsDefault($i,'array')."\"";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsNew($i,'array')."\"";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsDraft($i,'array')."\"";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsUpdate($i,'array')."\"";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsDelete($i,'array')."\"";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsActive($i,'array')."\"";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDepartmentId($i,'array')."\"
							THEN \"".$this->model->getIsApproved($i,'array')."\"";
						}
						break;
				}


				$sqlLooping.= " END,";
			}

			$sql.=substr($sqlLooping,0,-1);
			if($this->getVendor() == self::mysql) {
				$sql.="
			WHERE `".$this->model->getPrimaryKeyName()."` IN (".$this->model->getPrimaryKeyAll().")";
			} else if($this->getVendor()==self::mssql) {
				$sql.="
			WHERE `=[".$this->model->getPrimaryKeyName()."] IN (".$this->model->getPrimaryKeyAll().")";
			} else if ($this->getVendor()==self::oracle) {
				$sql.="
			WHERE \"".$this->model->getPrimaryKeyName()."\" IN (".$this->model->getPrimaryKeyAll().")";
			}
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => true,
            "message" => "Deleted"
            ));
            exit();

	}





	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if($_SESSION['start']==0) {
			$sql=str_replace("LIMIT","",$_SESSION['sql']);
			$sql=str_replace($_SESSION['start'].",".$_SESSION['limit'],"",$sql);
		} else {
			$sql=$_SESSION['sql'];
		}
		$this->q->read($sql);

		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array(
					'borders' => array(
						'inside' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
		),
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
		),
		),
		);
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('D2','');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','defaultLabel');
		$this->excel->getActiveSheet()->setCellValue('D3','Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {


			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['defaultLabelNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="defaultLabel".rand(0,10000000).".xlsx";
		$path=$_SERVER['DOCUMENT_ROOT']."/".$this->application."/security/document/excel/".$filename;
		$objWriter->save($path);
		$this->audit->create_trail($this->leafId, $path,$filename);
		$file = fopen($path,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}




}

$defaultLabelObject  	= 	new defaultLabelClass();

/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{

	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$defaultLabelObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$defaultLabelObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Filtering
	 */

	if(isset($_POST['query'])){
		$defaultLabelObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$defaultLabelObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$defaultLabelObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$defaultLabelObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$defaultLabelObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$defaultLabelObject->create();
	}
	if($_POST['method']=='read') 	{

		$defaultLabelObject->read();

	}

	if($_POST['method']=='save') 	{

		$defaultLabelObject->update();

	}
	if($_POST['method']=='delete') 	{
		$defaultLabelObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['leafId'])){
		$defaultLabelObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$defaultLabelObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$defaultLabelObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {

			$defaultLabelObject->staff();
		}


	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if($_GET['method']=='updateStatus'){
		$defaultLabelObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['defaultLabelCode'])) {
		if (strlen($_GET['defaultLabelCode']) > 0) {
			$defaultLabelObject->duplicate();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$defaultLabelObject->excel();
		}
	}

}


?>

