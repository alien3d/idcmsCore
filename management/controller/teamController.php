<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/teamModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage Team Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TeamClass extends ConfigClass {
	/**
	 * Connection to the database
	 * @var string
	 */
	public $q;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string
	 */
	private $excel;
	/**
	 * Record Pagination
	 * @var string
	 */
	private $recordSet;
	/**
	 * Document Trail Audit.
	 * @var string
	 */
	private $documentTrail;
	/**
	 * System String Message.
	 * @var string $systemString;
	 */
	public $systemString;
	/**
	 * Audit Row TRUE or False
	 * @var bool
	 */
	private $audit;
	/**
	 * Log Sql Statement TRUE or False
	 * @var string
	 */
	private $log;
	/**
	 * Model
	 * @var string
	 */
	public $model;
	/**
	 * Audit Filter
	 * @var string
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string
	 */
	public $auditColumn;
	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var bool
	 */
	public $duplicateTest;
	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct ();
		//audit property
		$this->audit = 0; // By Default 0 - Off  1 - On
		$this->log = 1; // By Default 0 - Off  1 - On

		$this->model = new TeamModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->log;
		$this->q->setRequestDatabase($this->getRequestDatabase());
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );


		$this->systemString = new SystemString();
		$this->systemString->setVendor($this->getVendor());
		$this->systemString->setLeafId($this->getLeafId());
		$this->systemString->execute();

		$this->recordSet = new RecordSet ();
		$this->recordSet->setTableName ( $this->model->getTableName () );
		$this->recordSet->setPrimaryKeyName ( $this->model->getPrimaryKeyName () );
		$this->recordSet->execute ();

		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->setStaffId ( $this->getStaffId () );
		$this->documentTrail->setLanguageId ( $this->getLanguageId () );
		$this->documentTrail->setLeafId ( $this->getLeafId () );
		$this->documentTrail->execute ();

		$this->excel = new PHPExcel ();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->create ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			INSERT INTO `team`
					(
						`teamSequence`,													`teamCode`,
						`teamEnglish`,															`isDefault`,
						`isNew`,																`isDraft`,
						`isUpdate`,															`isDelete`,
						`isActive`,															`isApproved`,
						`isReview`,															`isPost`,
						`executeBy`,														`executeTime`
					)
			VALUES
					(
						'" . $this->model->getTeamSequence () . "',				'" . $this->model->getTeamCode () . "',
						'" . $this->model->getTeamNote () . "',						'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',				'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',			'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',			'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',			'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',						" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [team]
					(
						[teamSequence],													[teamCode],
						[teamEnglish],															[isDefault],
						[isNew],																[isDraft],
						[isUpdate],															[isDelete],
						[isActive],																[isApproved],
						[isReview],															[isPost],
						[executeBy],															[executeTime]
					)
			VALUES
					(
						'" . $this->model->getTeamSequence () . "',			'" . $this->model->getTeamCode () . "',
						'" . $this->model->getTeamNote () . "',					'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',			'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',		'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',		'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',		'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',					" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO TEAM
					(
						TEAMSEQUENCE,													TEAMCODE,
						TEAMNOTE,															ISDEFAULT,
						ISNEW,																	ISDRAFT,
						ISUPDATE,															ISDELETE,
						ISACTIVE,																ISAPPROVED,
						ISREVIEW,															ISPOST,
						EXECUTEBY,															EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getTeamSequence () . "',			'" . $this->model->getTeamCode () . "',
						'" . $this->model->getTeamNote () . "',					'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',			'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',		'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',		'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',		'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',					" . $this->model->getExecuteTime () . "
					);";
		}
		$this->q->create ( $sql );
		// take from last insert id
		$lastInsertId = $this->q->lastInsertId ();
		// loop the tab and create new record
		//** no need to log in db
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT 	*
		FROM 	`module`
		WHERE 	`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT 	*
		FROM 	[module]
		WHERE 	[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT 	*
		FROM 	MODULE
		WHERE 	ISACTIVE=1";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$data = $this->q->activeRecord ();
		$sqlLooping = null;
		if ($this->q->numberRows () > 0) {
			foreach ( $data as $row ) {

				$sqlLooping .= "
					(
									'" . $row ['moduleId'] . "',
									0,
									'" . $lastInsertId . "'
					),";
					
			}
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "	INSERT INTO	`moduleAccess`
				(
									`moduleId`,
									`moduleAccessValue`,
									`teamId`
				)
				VALUES ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "	INSERT INTO	[moduleAccess]
				(
									[moduleId],
									[moduleAccessValue],
									[teamId]
				)
				VALUES ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "	INSERT INTO	MODULEACCESS
				(
									MODULEID,
									MODULEACCESSVALUE,
									TEAMID
				)
				VALUES ";
		}
		$sqlLooping .= substr ( $sqlLooping, 0, - 1 );
		$sql .= $sqlLooping;
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		// loop the folder and create new record;
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT 	*
		FROM 	`folder`
		WHERE 	`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT 	*
		FROM 	[folder]
		WHERE 	[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT 	*
		FROM 	FOLDER
		WHERE 	ISACTIVE=1";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$sqlLooping = null;
		if ($this->q->numberRows () > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $row ) {

				$sqlLooping .= "
					(
						'" . $row ['folderId'] . "',
						0,
						'" . $lastInsertId . "'
					),";
					
			}
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					INSERT INTO 	`folderAccess`
								(
									`folderId`,
									`folderAccessValue`,
									`teamId`
								)
					VALUES";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					INSERT INTO 	[folderAccess]
								(
									[folderId],
									[folderAccessValue],
									[teamId]
								)
					";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					INSERT INTO 	FOLDERACCESS
								(
									FOLDERID,
									FOLDERACCESSVALUE,
									TEAMID
								)
					VALUES ";
		}
		$sqlLooping .= substr ( $sqlLooping, 0, - 1 );
		$sql .= $sqlLooping;
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		// create a template access which user can access to
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SELECT * FROM `leaf` WHERE `isActive`=1  ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "SELECT * FROM [leaf] WHERE [isActive]=1  ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "SELECT * FROM LEAF WHERE ISACTIVE=1  ";
		}
		$this->q->read ( $sql );
		$sqlLooping = null;
		$total = $this->q->numberRows ();
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		if ($total > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $row ) {

				$sqlLooping .= "
					(
						'" . $row ['leafId'] . "',
						0,
						0,
						0,
						0,
						0,
						0,
						'" . $lastInsertId . "'
					),";
					
			}
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					INSERT INTO 	`leafTeamAccess`
								(
									`leafId`,
									`leafTeamAccessReadValue`,
									`leafTeamAccessCreateValue`,
									`leafTeamAccessUpdateValue`,
									`leafTeamAccessDeleteValue`,
									`leafTeamAccessPrintValue`,
									`leafTeamAccessPostValue`,
									`teamId`
								)
					VALUES";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					INSERT INTO 	[leafTeamAccess]
								(	[leafId],
									[leafTeamAccessReadValue],
									[leafTeamAccessCreateValue],
									[leafTeamAccessUpdateValue],
									[leafTeamAccessDeleteValue],
									[leafTeamAccessPrintValue],
									[leafTeamAccessPostValue],
									[teamId]
								)
					VALUES";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					INSERT INTO 	LEAFTEAMACCESS
								(
									LEAFID,
									LEAFTEAMACCESSREADVALUE,
									LEAFTEAMACCESSCREATEVALUE,
									LEAFTEAMACCESSUPDATEVALUE,
									LEAFTEAMACCESSDELETEVALUE,
									LEAFTEAMACCESSPRINTVALUE,
									LEAFTEAMACCESSPOSTVALUE,
									TEAMID
								)
					VALUES ";
		}
		$sqlLooping .= substr ( $sqlLooping, 0, - 1 );
		$sql .= $sqlLooping;
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
				 	"message" => $this->systemString->getCreateMessage(),
					"time"=>$time ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getIsAdmin() == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`team`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[team].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	TEAM.ISACTIVE	=	1	";
			}
		} else if ($this->getIsAdmin() == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	 1 = 1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " 1 = 1 ";
			}
		}


		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$items = array();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	`team`.`teamId`,
						`team`.`teamSequence`,
						`team`.`teamCode`,
						`team`.`teamEnglish`,
						`team`.`isDefault`,
						`team`.`isNew`,
						`team`.`isDraft`,
						`team`.`isUpdate`,
						`team`.`isDelete`,
						`team`.`isActive`,
						`team`.`isApproved`,
						`team`.`isReview`,
						`team`.`isPost`,
						`team`.`executeBy`,
						`team`.`executeTime`,
						`staff`.`staffName`
			FROM 	`team`
			JOIN		`staff`
			ON		`team`.`executeBy` = `staff`.`staffId`
			WHERE 	" . $this->auditFilter;
			if ($this->model->getTeamId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`." . $this->model->getPrimaryKeyName () . "`='" . $this->model->getTeamId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	[team].[teamId],
						[team].[teamSequence],
						[team].[teamCode],
						[team].[teamEnglish],
						[team].[isDefault],
						[team].[isNew],
						[team].[isDraft],
						[team].[isUpdate],
						[team].[isDelete],
						[team].[isActive],
						[team].[isReview],
						[team].[isPost],
						[team].[isApproved],
						[team].[executeBy],
						[team].[executeTime],
						[staff].[staffName]
			FROM 	[team]
			JOIN		[staff]
			ON		[team].[executeBy] = [staff].[staffId]
			WHERE " . $this->auditFilter;
			if ($this->model->getTeamId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getTeamId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	TEAM.TEAMID  				AS	\"teamId\",
						TEAM.GROUPCODE 		AS 	\"teamCode\",
						TEAM.GROUPSEQUENCE	AS 	\"teamSequence\",
						TEAM.TEAMENGLISH 		AS 	\"teamEnglish\",
						TEAM.ISDEFAULT 			AS 	\"isDefault\",
						TEAM.ISNEW 				AS 	\"isNew\",
						TEAM.ISDRAFT 				AS 	\"isDraft\",
						TEAM.ISUPDATE 			AS 	\"isUpdate\",
						TEAM.ISDELETE 			AS 	\"isDelete\",
						TEAM.ISACTIVE 			AS 	\"isActive\",
						TEAM.ISAPPROVED 		AS 	\"isApproved\",
						TEAM.ISREVIEW 			AS 	\"isReview\",
						TEAM.ISPOST		 		AS 	\"isPost\",
						TEAM.EXECUTEBY 			AS 	\"executeBy\",
						TEAM.EXECUTETIME 		AS 	\"executeTime\",
						STAFF.STAFFNAME 		AS 	\"staffName\"
			FROM 	TEAM
			JOIN		STAFF
			ON		TEAM.EXECUTEBY = STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			if ($this->model->getTeamId ( 0, 'single' )) {
				$sql .= " AND '" . strtoupper ( $this->model->getTableName () ) . "'.'" . strtoupper ( $this->model->getPrimaryKeyName () ) . "'='" . $this->model->getTeamId ( 0, 'single' ) . "'";
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getNonSupportedDatabase() ) );
			exit ();
		}
		/**
		 * filter column based on first character
		 */
		if($this->getCharacterQuery()){
			if($this->q->vendor==self::MYSQL){
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getFilterCharacter()."` like '".$this->getCharacterQuery()."%'";
			} else if($this->q->vendor==self::MSSQL){
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getFilterCharacter()."] like '".$this->getCharacterQuery()."%'";
			} else if ($this->q->vendor==self::ORACLE){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			} else if ($this->q->vendor==self::DB2){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			} else if ($this->q->vendor==self::POSTGRESS){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			}
		}
		/**
		 * filter column based on Range Of Date
		 * Example Day,Week,Month,Year
		 */
		if($this->getDateRangeStartQuery()){
			$sql.=$this->q->dateFilter($sql, $this->model->getTableName(),$this->model->getFilterDate(),$this->getDateRangeStartQuery(),$this->getDateRangeEndQuery(),$this->getDateRangeType());
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array ('teamId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('team' );
		if ($this->getFieldQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->quickSearch ( $tableArray, $filterArray );
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->searching ();
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			}
		}
		/** // optional debugger.uncomment if wanted to used

		echo json_encode(array(
		"success" => false,
		"message" => $this->q->realEscapeString($sql)
		));
		exit();

		*/
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$total = $this->q->numberRows ();
		if ($this->getOrder () && $this->getSortField ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField () . "` " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField () . "] " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper ( $this->getSortField () ) . "  " . strtoupper ( $this->getOrder () ) . " ";
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart ();
		$_SESSION ['limit'] = $this->getLimit ();
		if ($this->getLimit ()) {
			// only mysql have limit
			if ($this->getVendor () == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart () . "," . $this->getLimit () . " ";
			} else if ($this->getVendor () == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sql = "
							WITH [teamDerived] AS
							(
								
								SELECT	[team].[teamId],
											[team].[teamSequence],
											[team].[teamCode],
											[team].[teamEnglish],
											[team].[isDefault],
											[team].[isNew],
											[team].[isDraft],
											[team].[isUpdate],
											[team].[isDelete],
											[team].[isActive],
											[team].[isReview],
											[team].[isPost],
											[team].[isApproved],
											[team].[executeBy],
											[team].[executeTime],
											[staff].[staffName],
											ROW_NUMBER() OVER (ORDER BY [teamId]) AS 'RowNumber'
								FROM 	[team]
								JOIN		[staff]
								ON		[team].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT * 
							FROM 	[teamDerived]
							JOIN		[staff]
							ON		[team].[executeBy] = [staff].[staffId]
							WHERE " . $this->auditFilter . "	[RowNumber]
							BETWEEN	" . $this->getStart () . "
							AND 			" . ($this->getStart () + $this->getLimit () - 1) . ";";
			} else if ($this->getVendor () == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */
				$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT	TEAM.TEAMID  				AS	\"teamId\",
												TEAM.GROUPCODE 		AS 	\"teamCode\",
												TEAM.GROUPSEQUENCE	AS 	\"teamSequence\",
												TEAM.TEAMENGLISH 		AS 	\"teamEnglish\",
												TEAM.ISDEFAULT 			AS 	\"isDefault\",
												TEAM.ISNEW 				AS 	\"isNew\",
												TEAM.ISDRAFT 				AS 	\"isDraft\",
												TEAM.ISUPDATE 			AS 	\"isUpdate\",
												TEAM.ISDELETE 			AS 	\"isDelete\",
												TEAM.ISACTIVE 			AS 	\"isActive\",
												TEAM.ISAPPROVED 		AS 	\"isApproved\",
												TEAM.ISREVIEW 			AS 	\"isReview\",
												TEAM.ISPOST		 		AS 	\"isPost\",
												TEAM.EXECUTEBY 			AS 	\"executeBy\",
												TEAM.EXECUTETIME 		AS 	\"executeTime\",
												STAFF.STAFFNAME 		AS 	\"staffName\"
									FROM 	TEAM
									JOIN		STAFF
									ON		TEAM.EXECUTEBY = STAFF.STAFFID
									WHERE 	" . $this->auditFilter . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart () + $this->getLimit () - 1) . "' )
						where r >=  '" . $this->getStart () . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit ();
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (! ($this->model->getTeamId ( 0, 'single' ))) {
			$this->q->read ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$items = array ();
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			$items [] = $row;
		}
		if ($this->model->getTeamId ( 0, 'single' )) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' => true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getTeamId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getTeamId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
							'data' => $items ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			$end = microtime(true);
			$time = $end - $start;
			if (count ( $items ) == 0) {
				$items = '';
			}
			echo json_encode (
			array (	'success' => true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getTeamId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getTeamId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
						'data' => $items ) );
			exit ();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->update ();
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT	`" . $this->model->getPrimaryKeyName () . "`
		FROM 	`" . $this->model->getTableName () . "`
		WHERE  	`" . $this->model->getPrimaryKeyName () . "` = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName () . "]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE  	[" . $this->model->getPrimaryKeyName () . "] = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
		WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
				WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
			FROM 	" . strtoupper ( $this->model->getTableName () ) . "
			WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result, $sql );
		if ($total == 0) {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getRecordNotFound() ) );
			exit ();
		} else {
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			UPDATE 	`team`
			SET 			`teamSequence`	=   '" . $this->model->getTeamSequence () . "',
							`teamCode`			=	'" . $this->model->getTeamCode () . "',
							`teamEnglish`			=	'" . $this->model->getTeamNote () . "',
							`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isActive`				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`executeBy`			=	'" . $this->model->getExecuteBy () . "',
							`executeTime`		=	" . $this->model->getExecuteTime () . "
			WHERE 		`teamId`				=	'" . $this->model->getTeamId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			UPDATE 	[team]
			SET 			[teamSequence] 	=   '" . $this->model->getTeamSequence () . "',
							[teamCode]			=	'" . $this->model->getTeamCode () . "',
							[teamEnglish]			=	'" . $this->model->getTeamNote () . "',
							[isDefault]				=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isNew]					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isActive]				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isApproved]			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[executeBy]			=	'" . $this->model->getExecuteBy () . "',
							[executeTime]		=	" . $this->model->getExecuteTime () . "
			WHERE 		[teamId]				=	'" . $this->model->getTeamId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			UPDATE 	TEAM
			SET 			TEAMSEQUENCE	=   '" . $this->model->getTeamSequence () . "',
							TEAMCODE			=	'" . $this->model->getTeamCode () . "',
							TEAMNOTE			=	'" . $this->model->getTeamNote () . "',
							ISACTIVE				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 		TEAMID					=	'" . $this->model->getTeamCode ( 0, 'single' ) . "'";
			}
			$this->q->update ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array ("success" => true,
					"message" => $this->systemString->getUpdateMessage(),
					"time"=>$time ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->delete ();
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT	`" . $this->model->getPrimaryKeyName () . "`
		FROM 	`" . $this->model->getTableName () . "`
		WHERE  	`" . $this->model->getPrimaryKeyName () . "` = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName () . "]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE  	[" . $this->model->getPrimaryKeyName () . "] = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
		WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
				WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
			FROM 	" . strtoupper ( $this->model->getTableName () ) . "
			WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getTeamId ( 0, 'single' ) . "' ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result, $sql );
		if ($total == 0) {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getRecordNotFound() ) );
			exit ();
		} else {
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			UPDATE 	`team`
			SET 			`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isActive`				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`executeBy`			=	'" . $this->model->getExecuteBy () . "',
							`executeTime`		=	" . $this->model->getExecuteTime () . "
			WHERE 		`teamId`				=	'" . $this->model->getTeamId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			UPDATE 	[team]
			SET 			[isDefault]				=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isNew]					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isActive]				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isApproved]			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[executeBy]			=	'" . $this->model->getExecuteBy () . "',
							[executeTime]		=	" . $this->model->getExecuteTime () . "
			WHERE 		[teamId]				=	'" . $this->model->getTeamId . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			UPDATE 	TEAM
			SET 			TEAMDESC			=	'" . $this->model->getTeamDesc ( 0, 'single' ) . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISNEW					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISACTIVE				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 		TEAMID					=	'" . $this->model->getTeamId () . "'";
			}
			// advance logging future
			$this->q->tableName = $this->model->getTableName ();
			$this->q->primaryKeyName = $this->model->getPrimaryKeyName ();
			$this->q->primaryKeyValue = $this->model->getTeamId ();
			$this->q->audit = $this->audit;
			$this->q->update ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time ) );
		exit ();
	}
	/**
	 * To Update flag Status
	 */
	function updateStatus() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$loop = $this->model->getTotal();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE `" . $this->model->getTableName() . "`
			SET";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET 	";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		/**
		 * System Validation Checking
		 * @var $access
		 */
		$access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost");
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'isDefault' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isNew' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDraft' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isUpdate' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDelete' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isActive' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsActive($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isApproved' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isReview' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsReview($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                            WHEN '" . $this->model->getTeamId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isPost' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsPost($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getTeamId($i, 'array') . "'
                                THEN '" . $this->model->getIsPost($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
			}
		}
		$sql .= substr($sqlLooping, 0, - 1);
		if ($this->getVendor() == self::MYSQL) {
			$sql .= "
			WHERE `" . $this->model->getPrimaryKeyName() . "` IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql .= "
			WHERE [" . $this->model->getPrimaryKeyName() . "] IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::DB2) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		if ($this->getIsAdmin()) {
			$message = $this->systemString->getUpdateMessage();
		} else {
			$message = $this->systemString->getDeleteMessage();
		}
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" => true,
					"message" => $message,
					"time"=>$time)
		);
		exit();
	}
	/**
	 * To check if a key duplicate or not
	 */
	function duplicate() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`team`
			WHERE 	`teamCode` 	= 	'" . $this->model->getTeamCode () . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[team]
			WHERE 	[teamCode] 	= 	'" . $this->model->getTeamCode () . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	TEAM
			WHERE 	TEAMCODE 		= 	'" . $this->model->getTeamCode () . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT	*
			FROM 	TEAM
			WHERE 	TEAMCODE 		= 	'" . $this->model->getTeamCode () . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	*
			FROM 	TEAM
			WHERE 	TEAMCODE 		= 	'" . $this->model->getTeamCode () . "'
			AND		ISACTIVE		=	1";
		}
		$this->q->read ( $sql );
		$total = 0;
		$total = $this->q->numberRows ();
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		} else {
			$row = $this->q->fetchArray ();
			if ($this->duplicateTest == 1) {
				return $total . "|" . $row ['teamCode'];
			} else {
				$end = microtime(true);
				$time = $end - $start;
				echo json_encode (
				array (	"success" => true,
						"total" => $total, 
						"message" => $this->systemString->getDuplicateMessage(), 
						"teamCode" => $row ['teamCode'],
						"time"=>$time ) );
				exit ();
			}
		}
	}
	function firstRecord($value) {
		$this->recordSet->firstRecord ( $value );
	}
	function nextRecord($value, $primaryKeyValue) {
		$this->recordSet->nextRecord ( $value, $primaryKeyValue );
	}
	function previousRecord($value, $primaryKeyValue) {
		$this->recordSet->previousRecord ( $value, $primaryKeyValue );
	}
	function lastRecord($value) {
		$this->recordSet->lastRecord ( $value );
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
	}
}
$teamObject = new TeamClass ();
/**
 * crud -create,read,update,delete
 **/
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$teamObject->setLeafId($_POST ['leafId']);
	}
	/*
	 *  Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$teamObject->setIsAdmin($_POST ['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_POST ['databaseRequest'])) {
		$teamObject->setDatabaseRequest($_POST ['databaseRequest']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$teamObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$teamObject->setLimit($_POST ['perPage']);
	}
	/*
	 * Filtering
	 */
	if (isset($_POST ['query'])) {
		$teamObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$teamObject->setGridQuery($_POST ['filter']);
	}
	if (isset($_POST ['character'])) {
		$teamObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$teamObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$teamObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {
		$teamObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$teamObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$teamObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$teamObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$teamObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$teamObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$teamObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$teamObject->delete ();
	}
}
if (isset ( $_GET ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_GET ['leafId'] )) {
		$teamObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$teamObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$teamObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$teamObject->staff ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$teamObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['teamCode'] )) {
		if (strlen ( $_GET ['teamCode'] ) > 0) {
			$teamObject->duplicate ();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$teamObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$teamObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$teamObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$teamObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$teamObject->excel ();
		}
	}
}
?>
