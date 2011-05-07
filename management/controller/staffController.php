<?php	session_start();
require_once("../../class/classAbstract.php");
require_once ("../../class/classAudit.php");
require_once("../model/staffModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan,yusof
 * @package staff
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class staffClass extends  configClass {
	/**
	 * Connection to the database
	 * @var string $excel
	 */
	public $q;

	/**
	 * Program Identification
	 * @var numeric $leafId
	 */
	public $leafId;
	/**
	 * User Identification
	 * @var numeric $staffId
	 */
	public $staffId;
	/**
	 *	 Database Selected
	 *   string $database;
	 */
	public $database;
	/**
	 * Database Vendor
	 * @var string $vendor
	 */
	public $vendor;
	/**
	 * Extjs Grid Filter Array
	 * @var string $filter
	 */
	public $filter;
	/**
	 * Extjs Grid  single query information
	 * @var string $query
	 */
	public $query;
	/**
	 * Fast Search Variable
	 * @var string $quickFilter
	 */
	public $quickFilter;

	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
	 */
	private  $excel;


	/**
	 * Document Trail Audit.
	 * @var string $doc_$trail;
	 */
	private  $doc_trail;

	/**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;

	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sort_field
	 */
	public $sort_field;
	/**
	 * Default Language  : English
	 * @var numeric $defaultLanguageId
	 */
	private $defaultLanguageId;
	/**
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Current Table Staff Indentification Value
	 * @var numeric $staffId
	 */
	public $staffId;
	/**
	 * Current Staff Session Indentification Value
	 * @var numeric $staffSessionId
	 */
	public $staffSessionId;
	
	/**
	 * Class Loader
	 */
	public function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId;

		$this->q->staffId			=	$this->staffSessionId;

		$this->q->filter 			= 	$this->filter;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;
		
		$this->model				= new staffModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->audit = new auditClass();
	
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create() 				{
		header('Content-Type','application/json; charset=utf-8');
		//UTF8
		if($this->q->vendor=='mysql' || $this->q->vendor=='mysql'){
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}

		$this->q->start();
		if( $this->q->vendor=='mysql') {
			$sql	=	"
				INSERT INTO `staff` 	(
							`staffName`,		`staffNo`,
							`staffPassword`,	`staffIc`,
							`groupId`,			`By`,
							`Time`
				)  VALUES	(
					'".$this->strict($_POST['staffName'],'username')."',
					'".$this->strict($_POST['staffNo'],'string')."',
					'".md5($this->strict($_POST['staffPassword'],'password'))."',
					'".$this->strict($_POST['staffIc'],'string')."',
					'".$this->strict($_POST['groupId'],'numeric')."',
					'".$_SESSION['languageId']."',
					'".$_SESSION['staffId']."',
					'".date("Y-m-d H:i:s")."'
				);";
		} else if ($this->q->vendor=='microsoft'){
			$sql	=	"
				INSERT INTO [staff] 	(
							[staffName],		[staffNo],
							[staffPassword],	[staffIc],
							[groupId],			[By],
							[Time]
				)  VALUES	(
					'".$this->strict($_POST['staffName'],'username')."',
					'".$this->strict($_POST['staffNo'],'string')."',
					'".md5($this->strict($_POST['staffPassword'],'password'))."',
					'".$this->strict($_POST['staffIc'],'string')."',
					'".$this->strict($_POST['groupId'],'numeric')."',
					'".$_SESSION['languageId']."',
					'".$_SESSION['staffId']."',
					'".date("Y-m-d H:i:s")."'
				);";
		} else if ($this->q->vendor='oracle'){
			$sql	=	"
				INSERT INTO \"staff\" 	(
							\"staffName\",		\"staffNo\",
							\"staffPassword\",	\"staffIc\",
							\"groupId\",		\"By\",
							\"Time\"
				)  VALUES	(
					'".$this->strict($_POST['staffName'],'username')."',
					'".$this->strict($_POST['staffNo'],'string')."',
					'".md5($this->strict($_POST['staffPassword'],'password'))."',
					'".$this->strict($_POST['staffIc'],'string')."',
					'".$this->strict($_POST['groupId'],'numeric')."',
					'".$_SESSION['languageId']."',
					'".$_SESSION['staffId']."',
					'".date("Y-m-d H:i:s")."'
				);";
		}
		$this->q->create($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		$this->insert_id = $this->q->last_insert_id();
		// insert accordion access
		if( $this->q->vendor=='mysql') {
			$sql="
				SELECT	*
				FROM 	`accordion`
				WHERE 	`isActive`	=	1	";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				SELECT	*
				FROM 	[accordion]
				WHERE 	[isActive]	=	1	";
		} else if($this->q->vendor=='oracle') {
			$sql="
				SELECT	*
				FROM 	\"accordion\"
				WHERE 	\"isActive\"	=	1	";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		if($this->q->numberRows()> 0 ){
			$data = $this->q->activeRecord();

			foreach($data as $row) {
				// check if group access define in  accordionAccess else insert
				if( $this->q->vendor=='mysql') {
					$sql="
						SELECT *
						FROM 	`accordionAccess`
						WHERE 	`groupId`			=	'".$this->strict($_POST['groupId'],'numeric')."'
						AND		`accordionId`		=	'".$row['accordionId']."'";
				} else if ($this->q->vendor=='microsoft') {
					$sql="
						SELECT *
						FROM 	[accordionAccess`
						WHERE 	[groupId`			=	'".$this->strict($_POST['groupId'],'numeric')."'
					AND		`accordionId`			=	'".$row['accordionId']."'";
				} else if ($this->q->vendor=='oracle') {
					$sql="
						SELECT *
						FROM 	\"accordionAccess\"
						WHERE 	\"groupId\"			=	'".$this->strict($_POST['groupId'],'numeric')."'
						AND		\"accordionId\"		=	'".$row['accordionId']."'";
				}
				$this->q->read($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
					exit();
				}
				if($this->q->numberRows() ==  0 ){

					// record don't exist create new
					if($this->q->vendor=='mysql' || $this->q->vendor='mysql'){
						$sql="
						INSERT INTO `accordionAccess`	(
									`accordionId`,				`groupId`,
									`accordionAccessValue`
						)	VALUES(
							'".$row['accordionId']."',
							'".$this->strict($_POST['groupId'],'numeric')."',
							'0',
							'".$_SESSION['staffId']."',
							'".date("Y-m-d H:i:s")."
						)	";
					} else if ($this->q->vendor=='microsft'){
						$sql="
						INSERT INTO [accordionAccess]	(
									[accordionId],				[groupId],
									[accordionAccessValue]
						)	VALUES(
							'".$row['accordionId']."',
							'".$this->strict($_POST['groupId'],'numeric')."',
							'0',
							'".$_SESSION['staffId']."',
							'".date("Y-m-d H:i:s")."
						)	";
					} else if ($this->q->vendor=='oracle'){
						$sql="
						INSERT INTO \"accordionAccess\"	(
									\"accordionId\",				\"groupId\",
									\"accordionAccessValue\"
						)	VALUES(
							'".$row['accordionId']."',
							'".$this->strict($_POST['groupId'],'numeric')."',
							'0',
							'".$_SESSION['staffId']."',
							'".date("Y-m-d H:i:s")."
						)	";
					}
					$this->q->create($sql);
					if($this->q->execute=='fail'){
						echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
						exit();
					}
				}
			}
		}
		// insert folder access
		if( $this->q->vendor=='mysql') {
			$sql="
				SELECT	*
				FROM 	`folder`
				WHERE 	`isActive`=1";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				SELECT	*
				FROM 	[folder]
				WHERE 	[isActive]=1";
		} else if ($this->q->vendor=='oracle') {
			$sql="
				SELECT	*
				FROM 	\"folder\"
				WHERE 	\"isActive\"=1";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		if($this->q->numberRows()>0){
			$data = $this->q->activeRecord();
			foreach($data as $row) {
				// check if group access define in  accordionAccess else insert
				if( $this->q->vendor=='mysql') {
					$sql="
					SELECT *
					FROM 	`folderAccess`
					WHERE 	`groupId`='".$this->strict($_POST['groupId'],'numeric')."'
					AND		`folderId`='".$row['folderId']."'";
				} else if ($this->q->vendor=='microsoft') {
					$sql="
					SELECT *
					FROM 	[folderAccess]
					WHERE 	[groupId]='".$this->strict($_POST['groupId'],'numeric')."'
					AND		[folderId]='".$row['folderId']."'";
				} else if ($this->q->vendor=='oracle') {
					$sql="
					SELECT *
					FROM 	\"folderAccess\"
					WHERE 	\"groupId\"='".$this->strict($_POST['groupId'],'numeric')."'
					AND		\"folderId\"='".$row['folderId']."'";
				}
				$this->q->read($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
					exit();
				}
				if($this->q->numberRows()> 0 ){
					// record exist do nothing
				} else {
					// record don't exist create new
					if( $this->q->vendor=='mysql') {
						$sql="
					INSERT INTO `folderAccess`
						(
								`folderId`,
								`groupId`,
								`folderAccessValue`
						)
					VALUES(
								'".$row['folderId']."',
								'".$this->strict($_POST['groupId'],'numeric')."',
								'0'
					)	";
					} else if ($this->q->vendor=='microsoft') {
						$sql="
					INSERT INTO [folderAccess`
						(
								[folderId],
								[groupId],
								[folderAccessValue]
						)
					VALUES(
								'".$row['folderId']."',
								'".$this->strict($_POST['groupId'],'numeric')."',
								'0'
					)	";
					} else if ($this->q->vendor=='oracle') {
						$sql="
					INSERT INTO \"folderAccess\"
						(
								\"folderId\",
								\"groupId\",
								\"folderAccessValue\"
						)
					VALUES(
								'".$row['folderId']."',
								'".$this->strict($_POST['groupId'],'numeric')."',
								'0'
					)	";
					}
					$this->q->create($sql);
					if($this->q->execute=='fail'){
						echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
						exit();
					}
				}
			}
		}
		// insert leaf access according to the group choosen
		if( $this->q->vendor=='mysql') {
			$sql="
			SELECT	*
			FROM 	`leafGroupAccess`
			WHERE 	`groupId`='".$this->strict($_POST['groupId'],'numeric')."' ";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
			SELECT	*
			FROM 	[leafGroupAccess]
			WHERE 	[groupId]='".$this->strict($_POST['groupId'],'numeric')."' ";
		} else if  ($this->q->Vendor=='oracle') {
			$sql="
			SELECT	*
			FROM 	\"leafGroupAccess\"
			WHERE 	\"groupId\"='".$this->strict($_POST['groupId'],'numeric')."' ";
		}
		$this->q->read($sql);


		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		if($this->q->numberRows()> 0 ) {
			$data = $this->q->activeRecord();

			foreach ($data as  $row_group_acs) {
				if( $this->q->vendor=='mysql') {
					$sql="
				INSERT INTO	`leafAccess`
					(
							`leafId`,
							`staffId`,
							`leafCreateAccessValue`,
							`leafReadAccessValue`,
							`leafUpdateAccessValue`,
							`leafDeleteAccessValue`,
							`leafPrintAccessValue`,
							`leafPostAccessValue`
					)
				VALUES
					(
							'".$row_group_acs['leafId']."',
							'".$this->insert_id."',
							'".$row_group_acs['leafCreateAccessValue']."',
							'".$row_group_acs['leafReadAccessValue']."',
							'".$row_group_acs['leafUpdateAccessValue']."',
							'".$row_group_acs['leafDeleteAccessValue']."',
							'".$row_group_acs['leafPrintAccessValue']."',
							'".$row_group_acs['leafPostAccessValue']."'
					)	";
				} else if ($this->q->vendor=='microsoft') {
					$sql="
				INSERT INTO	[leafAccess]
					(
							[leafId],
							[staffId],
							[leafCreateAccessValue],
							[leafReadAccessValue],
							[leafUpdateAccessValue],
							[leafDeleteAccessValue],
							[leafPrintAccessValue],
							[leafPostAccessValue]
					)
				VALUES
					(
							'".$row_group_acs['leafId']."',
							'".$this->insert_id."',
							'".$row_group_acs['leafCreateAccessValue']."',
							'".$row_group_acs['leafReadAccessValue']."',
							'".$row_group_acs['leafUpdateAccessValue']."',
							'".$row_group_acs['leafDeleteAccessValue']."',
							'".$row_group_acs['leafPrintAccessValue']."',
							'".$row_group_acs['leafPostAccessValue']."'
					)	";
				} else if ($this->q->vendor=='oracle') {
					$sql="
				INSERT INTO	\"leafAccess`
					(
							\"leafId`,
							\"staffId`,
							\"leafCreateAccessValue\",
							\"leafReadAccessValue\",
							\"leafUpdateAccessValue\",
							\"leafDeleteAccessValue\",
							\"leafPrintAccessValue\",
							\"leafPostAccessValue\"
					)
				VALUES
					(
							'".$row_group_acs['leafId']."',
							'".$this->insert_id."',
							'".$row_group_acs['leafCreateAccessValue']."',
							'".$row_group_acs['leafReadAccessValue']."',
							'".$row_group_acs['leafUpdateAccessValue']."',
							'".$row_group_acs['leafDeleteAccessValue']."',
							'".$row_group_acs['leafPrintAccessValue']."',
							'".$row_group_acs['leafPostAccessValue']."'
					)	";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
					exit();
				}
			}
		}

		/**
		 * generate category for each staff
		 */
		for ($i = 1; $i <= 10; $i++) {
			if( $this->q->vendor=='mysql') {
				$sql = "
				INSERT INTO 	`calendar`
							(
								`calendarColorId`,
								`calendarTitle`,
								`staffId`
							) VALUES	(
								'".$i."',
								'"."other".$i."',
								'".$this->insert_id."'
							)";
			} else if ($this->q->vendor=='microsoft') {
				$sql = "
				INSERT INTO 	[calendar]
							(
								[calendarColorId],
								[calendarTitle],
								[staffId]
							) VALUES	(
								'".$i."',
								'"."other".$i."',
								'".$this->insert_id."'
							)";
			} else if ($this->q->vendor=='oracle') {
				$sql = "
				INSERT INTO 	\"calemdar\"
							(
								\"calendarColorId\",
								\"calendarTitle\",
								\"staffId\"
							) VALUES	(
								'".$i."',
								'"."other".$i."',
								'".$this->insert_id."'
							)";
			}
			$this->q->create($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
				exit();
			}
		}

		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Created"));
		exit();



	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor=='mysql') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}
		if( $this->q->vendor=='mysql') {
			$sql="
			SELECT	*
			FROM 	`staff`
			JOIN 	`group`
			USING 	(`groupId`)
			WHERE 	`staff`.`isActive`=1
			AND		`group`.`isActive`=1";
		}  else if ($this->q->vendor=='microsoft') {
			$sql="
			SELECT	*
			FROM 	[staff]
			JOIN 	[group]
			ON		[group].[groupId]=[staff].[groupId]
			WHERE 	[staff].[isActive]=1
			AND		[group].[isActive]=1";
		}  else if ($this->q->vendor=='oracle') {
			$sql="
			SELECT	*
			FROM 	\"staff\"
			JOIN 	\"group\"
			USING 	(\"groupId\")
			WHERE 	\"staff\".\"isActive\"=1
			AND		\"group\".\"isActive\"=1";
		}
		if($this->staffId) {
			$sql.=" AND `staffId`='".$this->staffId."'";
		}

		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('staff','group');
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		//$filterArray	=	array();
		if(isset($_GET['query'])) {
			$query = $_GET['query'];
		}  else if (isset($_POST['query'])) {
			$query = $_POST['query'];
		}
		if($query) {
			$sql.=$this->q->quickSearch($tableArray,$filterArray);
		}
		$record_all 	= $this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();

		}
		$this->total	= $this->q->numberRows();
		//paging
		// this is sorting  future
		if(empty($_GET['dir'])) {
			$dir = 'ASC';
		} else {
			$dir  = $_GET['dir'];
		}
		if(empty($_GET['sort'])) {
			$sort_field = "staffId";
		} else {
			$sort_field = $_GET['sort'];
		}
		$sql.="	ORDER BY `".$sort_field."` ".$dir." ";
		if(empty($_POST['filter']))      {
			if(isset($_POST['start']) && isset($_POST['limit'])) {
				$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
			}
		}
		$_SESSION['sql']=$sql; // push to session so can make report via excel and pdf


		$this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();

		}
		while($row  = 	$this->q->fetch_array()) {

			$items[]			=	$row;
		}



		if($_POST['method']=='read' && $_POST['mode']=='update') {
			$json_encode = json_encode(
			array('success'=>'true',
				'total' => $this->total,
				'data' => $items
			));
			$json_encode=str_replace("[","",$json_encode);
			$json_encode=str_replace("]","",$json_encode);
			echo $json_encode;
			exit();
		} else {
			if(count($items)==0) {
				$items='';
			}
			echo json_encode(
			array('success'=>'true',
				'total' => $this->total,
				'data' => $items
			));
			exit();

			// testing don't sent any reccord
		}


	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor=='mysql') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}

		$this->q->start();
		$this->model->update();
		//  original group
		if( $this->q->vendor=='mysql') {
			$sql="
			SELECT	`groupId`,
					`staffPassword` 
			FROM 	`staff` 
			WHERE 	`staffId`	=	'".$this->model->staffId."'";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
			SELECT 	[groupId],
					[staffPassword] 
			FROM 	[staff] 
			WHERE 	[staffId]	=	'".$this->model->staffId."'";
		} else if ($this->q->vendor=='oracle') {
			$sql="
			SELECT 	\"groupId\",
					\"staffPassword\" 
			FROM 	\"staff\" 
			WHERE 	\"staffId\"	=	'".$this->model->staffId."'";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail') {
			$this->msg(false,$this->q->result_text);
			exit();
		}
		$data = $this->q->fetchAssoc();

		if($data['staffPassword'] == $this->model->staffPassword){
			$staffPassword = $data['staffPassword'];
		}else{
			$staffPassword = $this->model->staffPassword;
		}

		$groupId = $data['groupId'];
		if( $this->q->vendor=='mysql') {
			$sql="
				UPDATE 	`staff`
				SET 	`staffIc`		=	'".$this->strict($_POST['staffIc'],'string')."',
						`staffName`		=	'".$this->strict($_POST['staffName'],'username')."',
						`staffNo`		=	'".$this->strict($_POST['staffNo'],'string')."',
						`staffPassword`	=	'".$this->strict($staffPassword,'password')."',
						`staffName`		=	'".$this->strict($_POST['staffName'],'string')."',
						`groupId`		=	'".$this->strict($_POST['groupId'],'numeric')."',
						`isActive`		=	'".$this->model->isActive."',
						`isNew`			=	'".$this->model->isNew."',
						`isDraft`		=	'".$this->model->isDraft."',
						`isUpdate`		=	'".$this->model->isUpdate."',
						`isDelete`		=	'".$this->model->isDelete."',
						`isApproved`	=	'".$this->model->isApproved."',
						`By`			=	'".$this->model->By."',
						`Time			=	".$this->model->Time."'
				WHERE 	`staffId`		=	'".$this->model->staffId."'";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				UPDATE 	[staff]
				SET 	[staffIc]		=	'".$this->strict($_POST['staffIc'],'string')."',
						[staffName]		=	'".$this->strict($_POST['staffName'],'username')."',
						[staffNo]		=	'".$this->strict($_POST['staffNo'],'string')."',
						[staffPassword]	=	'".$this->strict($staffPassword,'password')."',
						[staffName]		=	'".$this->strict($_POST['staffName'],'string')."',
						[groupId]		=	'".$this->strict($_POST['groupId'],'numeric')."',
						[isActive]		=	'".$this->model->isActive."',
						[isNew]			=	'".$this->model->isNew."',
						[isDraft]		=	'".$this->model->isDraft."',
						[isUpdate]		=	'".$this->model->isUpdate."',
						[isDelete]		=	'".$this->model->isDelete."',
						[isApproved]	=	'".$this->model->isApproved."',
						[By]			=	'".$this->model->By."',
						[Time]			=	".$this->model->Time."
				WHERE 	[staffId]		=	'".$this->model->staffId."'";
		} else if ($this->q->vendor=='oracle') {
			$sql="
				UPDATE 	\"staff\"
				SET 	\"staffIc\"			=	'".$this->strict($_POST['staffIc'],'string')."',
						\"staffName\"		=	'".$this->strict($_POST['staffName'],'username')."',
						\"staffNo\"			=	'".$this->strict($_POST['staffNo'],'string')."',
						\"staffPassword\"	=	'".$this->strict($staffPassword,'password')."',
						\"staffName\"		=	'".$this->strict($_POST['staffName'],'string')."',
						\"groupId\"			=	'".$this->strict($_POST['groupId'],'numeric')."',
						\"isActive\"		=	'".$this->model->isActive."',
						\"isNew\"			=	'".$this->model->isNew."',
						\"isDraft\"			=	'".$this->model->isDraft."',
						\"isUpdate\"		=	'".$this->model->isUpdate."',
						\"isDelete\"		=	'".$this->model->isDelete."',
						\"isApproved\"		=	'".$this->model->isApproved."',
						\"By\"				=	'".$this->model->By."',
						\"Time\"			=	".$this->model->Time."
				WHERE 	\"staffId\"			=	'".$this->model->staffId."'";
		}

		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();

		}
		// check change group or not
		if($this->model->groupId != $groupId){

			/**
			 *  update  leaf group access
			 * */
			if( $this->q->vendor=='mysql') {
				$sql="
					SELECT	*
					FROM 	`leafGroupAccess`
					WHERE 	`groupId`='".$this->model->groupId."' ";
			} else if ($this->q->vendor=='microsoft') {
				$sql="
					SELECT	*
					FROM 	[leafGroupAccess]
					WHERE 	[groupId]='".$this->model->groupId."' ";
			} else if ($this->q->vendor=='oracle') {
				$sql="
					SELECT	*
					FROM 	\"leafGroupAccess\"
					WHERE 	\"groupId\"='".$this->model->groupId."' ";
			}

			$this->q->read($sql);
			if($this->q->execute=='fail') {
				$this->msg(false,$this->q->result_text);
				exit();
			}
			$data = $this->q->activeRecord();
			foreach($data as  $row_group_acs) {
				// check if exist record or not
				if( $this->q->vendor=='mysql') {
					$sql="
					SELECT	*
					FROM 	`leafAccess`
					WHERE 	`staffId`			=	'".$this->model->staffId."'
					AND		`leafId`			=	'".$row_group_acs['leafId']."' ";
				} else if ($this->q->vendor=='microsoft') {
					$sql="
					SELECT	*
					FROM 	[leafAccess]
					WHERE 	[staffId]			=	'".$this->model->staffId."'
					AND		[leafId]			=	'".$row_group_acs['leafId']."' ";
				} else if ($this->q->vendor=='oracle') {
					$sql="
					SELECT	*
					FROM 	\"leafAccess\"
					WHERE 	\"staffId\"			=	'".$this->model->staffId."'
					AND		\"leafId\"			=	'".$row_group_acs['leafId']."' ";
				}
				$this->q->read($sql);
				if($this->q->numberRows()> 0 ) {
					if( $this->q->vendor=='mysql') {
						$sql="
						UPDATE 	`leafAccess`
						SET 	`leafCreateAccessValue`			=	'".$row_group_acs['leafCreateAccessValue']."',
								`leafDeleteAccessValue`			=	'".$row_group_acs['leafReadAccessValue']."',
								`leafPostAccessValue`			=	'".$row_group_acs['leafUpdateAccessValue']."',
								`leafPrintAccessValue`			=	'".$row_group_acs['leafDeleteAccessValue']."',
								`leafReadAccessValue`			=	'".$row_group_acs['leafPrintAccessValue']."',
								`leafUpdateAccessValue`			=	'".$row_group_acs['leafPostAccessValue']."'
						WHERE 	`staffId`						=	'".$this->model->staffId."'
						AND		`leafId`						=	'".$row_group_acs['leafId']."'";
					} else if ($this->q->vendor=='microsoft') {
						$sql="
						UPDATE 	[leafAccess]
						SET 	[leafCreateAccessValue]			=	'".$row_group_acs['leafCreateAccessValue']."',
								[leafDeleteAccessValue]			=	'".$row_group_acs['leafReadAccessValue']."',
								[leafPostAccessValue]			=	'".$row_group_acs['leafUpdateAccessValue']."',
								[leafPrintAccessValue]			=	'".$row_group_acs['leafDeleteAccessValue']."',
								[leafReadAccessValue]			=	'".$row_group_acs['leafPrintAccessValue']."',
								[leafUpdateAccessValue]			=	'".$row_group_acs['leafPostAccessValue']."'
						WHERE 	[staffId]						=	'".$this->model->staffId."'
						AND		[leafId]						=	'".$row_group_acs['leafId']."'";
					} else if ($this->q->vendor=='oracle') {
						$sql="
								UPDATE 	\"leafAccess\"
						SET 	\"leafCreateAccessValue\"		=	'".$row_group_acs['leafCreateAccessValue']."',
								\"leafDeleteAccessValue\"		=	'".$row_group_acs['leafReadAccessValue']."',
								\"leafPostAccessValue\"			=	'".$row_group_acs['leafUpdateAccessValue']."',
								\"leafPrintAccessValue\"		=	'".$row_group_acs['leafDeleteAccessValue']."',
								\"leafReadAccessValue\"			=	'".$row_group_acs['leafPrintAccessValue']."',
								\"leafUpdateAccessValue\"		=	'".$row_group_acs['leafPostAccessValue']."'
						WHERE 	\"staffId\"						=	'".$this->model->staffId."'
						AND		\"leafId\"						=	'".$row_group_acs['leafId']."'";
					}
					$this->q->update($sql);
					if($this->q->execute=='fail') {
						echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
						exit();

					}
				} else {
					if( $this->q->vendor=='mysql') {
						$sql="
							INSERT INTO	`leafAccess`
								(
										`leafId`,
										`staffId`,
										`leafReadAccessValue`,
										`leafUpdateAccessValue`,
										`leafDeleteAccessValue`,
										`leafPrintAccessValue`,
										`leafPostAccessValue`
								)
							VALUES
								(
										'".$row_group_acs['leafId']."',
										'".$this->model->staffId."',
										'".$row_group_acs['leafReadAccessValue']."',
										'".$row_group_acs['leafUpdateAccessValue']."',
										'".$row_group_acs['leafDeleteAccessValue']."',
										'".$row_group_acs['leafPrintAccessValue']."',
										'".$row_group_acs['leafPostAccessValue']."'
								)	";
					} else if ($this->q->vendor=='microsoft') {
						$sql="
							INSERT INTO	[leafAccess`
								(
										[leafId],
										[staffId],
										[leafReadAccessValue],
										[leafUpdateAccessValue],
										[leafDeleteAccessValue],
										[leafPrintAccessValue],
										[leafPostAccessValue]
								)
							VALUES
								(
										'".$row_group_acs['leafId']."',
										'".$this->model->staffId."',
										'".$row_group_acs['leafReadAccessValue']."',
										'".$row_group_acs['leafUpdateAccessValue']."',
										'".$row_group_acs['leafDeleteAccessValue']."',
										'".$row_group_acs['leafPrintAccessValue']."',
										'".$row_group_acs['leafPostAccessValue']."'
								)	";
					} else if ($this->q->vendor=='oracle') {
						$sql="
							INSERT INTO	\"leafAccess\"
								(
										\"leafId\",
										\"staffId\",
										\"leafReadAccessValue\",
										\"leafUpdateAccessValue\",
										\"leafDeleteAccessValue\",
										\"leafPrintAccessValue\",
										\"leafPostAccessValue\"
								)
							VALUES
								(
										'".$row_group_acs['leafId']."',
										'".$this->strict($_POST['staffId'],'numeric')."',
										'".$row_group_acs['leafReadAccessValue']."',
										'".$row_group_acs['leafUpdateAccessValue']."',
										'".$row_group_acs['leafDeleteAccessValue']."',
										'".$row_group_acs['leafPrintAccessValue']."',
										'".$row_group_acs['leafPostAccessValue']."'
								)	";
					}
					$this->q->create($sql);
					if($this->q->execute=='fail'){
						echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
						exit();
					}
				}
			}
		}
		// if change group .All access  before will deactivated
		// update leaf access to null
		$this->q->commit();
		echo json_encode(array("success"=>"success","message"=>"update success"));
		exit();


	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor=='mysql') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}

		$this->q->start();
		$this->model->delete();
		if( $this->q->vendor=='mysql') {
			$sql="
				UPDATE	`staff`
				SET		`isActive`			=	'".$this->model->isActive."',
						`isNew`				=	'".$this->model->isNew."',
						`isDraft`			=	'".$this->model->isDraft."',
						`isUpdate`			=	'".$this->model->isUpdate."',
						`isDelete`			=	'".$this->model->isDelete."',
						`isApproved`		=	'".$this->model->isApproved."',
						`By`				=	'".$this->model->By."',
						`Time				=	".$this->model->Time."
				WHERE 	`staffId`			=	'".$this->model->staffId."'";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				UPDATE	[staff]
				SET		[isActive]	=	'".$this->model->isActive."',
					[isNew]		=	'".$this->model->isNew."',
					[isDraft]	=	'".$this->model->isDraft."',
					[isUpdate]	=	'".$this->model->isUpdate."',
					[isDelete]	=	'".$this->model->isDelete."',
					[isApproved]=	'".$this->model->isApproved."',
					[By]		=	'".$this->model->By."',
					[Time]		=	".$this->model->Time."
				WHERE 	[staffId]	=	'".$this->model->staffId."'";

		} else if ($this->q->vendor=='oracle') {
			$sql="
				UPDATE	\"staff\"
				SET		\"isActive\"	=	0,
						\"isNew\"		=	0,
						\"isUpdate\"	=	0,
						\"isDelete\"	=	1
				WHERE 	\"staffId\"		=	'".$this->model->staffId."'";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"success","message"=>"Removed Success"));
		exit();


	}



	/**
	 * Enter description here ...
	 */
	public function group() {
		$this->security->group();
	}

	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel() {
		if( $this->q->vendor=='mysql') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}
		if($_SESSION['start']==0) {
			$sql=str_replace("LIMIT","",$_SESSION['sql']);
			$sql=str_replace($_SESSION['start'].",".$_SESSION['limit'],"",$sql);
		} else {
			$sql=$_SESSION['sql'];
		}
		$this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();

		}
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
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('D2','');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','Nama');
		$this->excel->getActiveSheet()->setCellValue('D3','Kumpulan');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetch_array()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['staffName']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['groupName']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="staff.xlsx";
		$objWriter->save($_SERVER['document_root']."/idcmsCore/management/document/excel/".$filename);

		$file = fopen($_SERVER['document_root']."/idcmsCore/management/document/excel/".$filename,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}

}

$staffObject  		= 	new staffClass();
if(isset($_SESSION['staffId'])){
	$staffObject->staffSessionId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$staffObject-> vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	if(isset($_POST['leafId'])){
		$staffObject-> leafId = $_POST['leafId'];
	}
	if($_POST['method']=='create')	{
		$staffObject->create();
	}
	if(isset($_POST['filter'])){
		$staffObject->filter = $_POST['filter'];
	}
	if(isset($_POST['query'])){
		$staffObject->query = $_POST['query'];
	}
	if(isset($_POST['order'])){
		$staffObject-> order= $_POST['order'];
	}
	if(isset($_POST['sort_field'])){
		$staffObject-> sort_field= $_POST['sort_field'];
	}
	if($_POST['method']=='read') 	{
		$staffObject->read();
	}
	if(isset($_POST['staffId'])) {
		$staffObject->staffId = $_POST['staffId'];
		if($_POST['method']=='save') 	{
			$staffObject->read();
		}
		if($_POST['method']=='delete') 	{
			$staffObject->delete();
		}
	}
}

if(isset($_GET['method'])) {
	if(isset($_GET['leafId'])){
		$staffObject-> leafId  = $_GET['leafId'];
	}
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$staffObject->staffId();
		}
	}

	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$staffObject->excel();
		}
	}
}
?>



