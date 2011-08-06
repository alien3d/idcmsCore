<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/eventModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package calendars
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class eventClass extends configClass
{
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
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();
		$this->q             = new vendor();
		$this->q->vendor     = $this->getVendor();
		$this->q->leafId     = $this->getLeafId();
		$this->q->staffId    = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery  = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel  = new PHPExcel();
		$this->audit  = 0;
		$this->log    = 1;
		$this->q->log = $this->log;
		$this->model  = new eventModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();
	}
	/* (non-PHPdoc)
	 * @see configClass::create()
	 */
	public function create()
	{
		header('Content-type: application/json');
		$this->model->create();
		$this->q->start();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `event`(
						`calendarId`,		`eventTitle`,
						`eventStart`,		`eventEnd`,
						`eventAd`,			`eventNotes`,
						`eventRem`,			`eventUrl`,
						`eventLoc`,			`eventN`,
						`staffId`,			`Time`
			)VALUES	(
				\"". $this->model->getCalendarId() ."\",	\"". $this->model->getEventTitle() ."\",
				\"". $this->model->getEventStart() ."\",	\"".$this->model->getEventEnd() ."\",
				\"".$this->model->getEventIsAllDay() ."\",	\"". $this->model->getEventNotes() ."\",
				\"". $this->model->getEventReminder() ."\",	\"". $this->model->getEventUrl() ."\",
				\"". $this->model->getEventLocation() ."\",	\"". $this->model->getEventIsNew() ."\",
				\"". $this->model->getBy() . "\",			" . $this->model->getTime() . "
				
							);";
		} else if ($this->getVendor() ==  self::mssql){
			$sql = "
			INSERT INTO [event`(
						[calendarId],		[eventTitle],
						[eventStart],		[eventEnd],
						[eventAd],			[eventNotes],
						[eventRem],			[eventUrl],
						[eventLoc],			[eventN],
						[staffId],			[Time]
			)VALUES	(
				\"". $this->model->getCalendarId() ."\",	\"". $this->model->getEventTitle() ."\",
				\"". $this->model->getEventStart() ."\",	\"".$this->model->getEventEnd() ."\",
				\"".$this->model->getEventIsAllDay() ."\",	\"". $this->model->getEventNotes() ."\",
				\"". $this->model->getEventReminder() ."\",	\"". $this->model->getEventUrl() ."\",
				\"". $this->model->getEventLocation() ."\",	\"". $this->model->getEventIsNew() ."\",
				\"". $this->model->getBy() . "\",			" . $this->model->getTime() . "
				
							);";
		}elseif ($this->getVendor()==self::oracle){
			$sql = "\"
			INSERT INTO \"event\" (
						\"calendarId\",		\"eventTitle\",
						\"eventStart\",		\"eventEnd\",
						\"eventAd\",			\"eventNotes\",
						\"eventRem\",			\"eventUrl\",
						\"eventLoc\",			\"eventN\",
						\"staffId\",			\"Time\"
			)VALUES	(
				\"". $this->model->getCalendarId() ."\",	\"". $this->model->getEventTitle() ."\",
				\"". $this->model->getEventStart() ."\",	\"".$this->model->getEventEnd() ."\",
				\"".$this->model->getEventIsAllDay() ."\",	\"". $this->model->getEventNotes() ."\",
				\"". $this->model->getEventReminder() ."\",	\"". $this->model->getEventUrl() ."\",
				\"". $this->model->getEventLocation() ."\",	\"". $this->model->getEventIsNew() ."\",
				\"". $this->model->getBy() . "\",			" . $this->model->getTime() . "
				
							);";
		}
		
		$this->q->create($sql);
		$this->q->commit();
	}
	/* (non-PHPdoc)
	 * @see configClass::read()
	 */
	public function read()
	{
		//	header('Content-type: application/json');
		if($this->getVendor()==self::mysql){
			$sql = "
			SELECT	*
			FROM 	`event`
			JOIN    `calendar`
			USING	(`calendarId`,`staffId`)
			JOIN	`calendarColor`
			USING   (`calendarColorId`)
			WHERE 	`calendar`.`staffId` = \"". $this->model->getBy()."\"";
			
			if($this->model->getEventStart() && $this->model->getEventEnd()){
				$sql.=" 
				AND	`event`.`eventStart` >= '".$this->model->getEventStart()."'
				AND	`event`.`eventEnd` 	<= '".$this->model->getEventEnd()."'";
			}

		} else if ($this->getVendor()  ==self::mssql){
			$sql = "
			SELECT	*
			FROM 	[event]
			JOIN    [calendar]
			ON		[event].[calendarId]= [calendar].[calendarId]
			AND		[event].[staffId] = [calendar].[staffId]
			JOIN	[calendarColor]
			ON		[calendarColor].[calendarColorId]= [calendar].[calendarColorId]
			WHERE 	[calendar].[staffId] = \"". $this->staffId ."\"";
		}  else if ($this->getVendor() == self :: oracle){
			$sql = "
			SELECT	*
			FROM 	\"event\"
			JOIN	\"calendar\"
			USING	(\"calendarId\",\"staffId\")
			JOIN    \"calendarColor\"
			USING   (\"calendarColorId\")
			WHERE 	\"calendar\".\"staffId\" = \"". $this->staffId ."\"";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" =>false,
                "message" => $this->q->responce
			));
			exit();
		}
		$total = $this->q->numberRows();
		$items = array();
		while ($row = $this->q->fetchAssoc()) {
				
			$items[] = $row;
		}
		if ($this->model->getEventId('','single')) {
			$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
				'message' => 'Data Loaded',
                'data' => $items
			));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(array(
                'success' => true,
                'total' => $total,
				'message'=>'data loaded',
                'data' => $items
			));
		}
			
	}
	/* (non-PHPdoc)
	 * @see configClass::update()
	 */
	function update()
	{
		header('Content-type: application/json');
		$this->model->update();
		$this->q->start();
		$sql = "
					UPDATE 	`event`
					SET 	`calendarId`	=	\"". $this->strict($_POST['calendar_uniqueId'], 'n') ."\",
							`eventTitle`	=	\"". $this->strict($_POST['title'], 's') ."\",
							`eventStart`	=	\"". date("Y-m-d H:i:s", strtotime($_POST['start'])) ."\",
							`eventEnd`	=	\"". date("Y-m-d H:i:s", strtotime($_POST['end'])) ."\",
							`eventAddress`    = 	\"". $this->strict($_POST['ad'], 'c') ."\",
							`EventNotes` = 	\"". $this->strict($_POST['notes'], 's') ."\",
							`eventReminder`	=	\"". $this->strict($_POST['rem'], 'c') ."\",
							`eventUrl`	=	\"". $this->strict($_POST['url'], 'c') ."\",
							`eventLocation`	=	\"". $this->strict($_POST['loc'], 's') ."\",
							`eventN`	=	\"". $this->strict($_POST['n'], 'c') ."\"
					WHERE 	`eventId`		=	\"". $this->strict($_POST['eventId'], 'n') ."\"";
		if($this->getVendor() == self::mysql){
			$sql = "
			UPDATE	`event`
			SET
					`calendarId`	=	\"".$this->model->getC."\",
					`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
					`isNew`			=	\"".$this->model->getIsNew('','single')."\",
					`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
					`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
					`isActive`		= 	\"".$this->model->getIsActive('','single')."\",
					`isApproved` 	=	\"".$this->model->getIsApproved('','single')."\"
			WHERE 	`eventId`		=	\"". $this->model->getEventId('','single')."\"";
		} else if ($this->q->vendor == self :: mssql){
			$sql = "
			UPDATE	[event]
			SET		[isDefault]		=	\"".$this->model->getIsDefault('','single')."\",
					[isNew]			=	\"".$this->model->getIsNew('','single')."\",
					[isDraft]		=	\"".$this->model->getIsDraft('','single')."\",
					[isUpdate]		=	\"".$this->model->getIsUpdate('','single')."\",
					[isActive]		= 	\"".$this->model->getIsActive('','single')."\",
					[isApproved] 	=	\"".$this->model->getIsApproved('','single')."\"
			WHERE 	[eventId]		=	\"". $this->model->getEventId('','single')."\"";
		} else if ($this->q->vendor == self:: oracle){
			$sql = "
			UPDATE	`event`
			SET		`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
					`isNew`			=	\"".$this->model->getIsNew('','single')."\",
					`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
					`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
					`isActive`		= 	\"".$this->model->getIsActive('','single')."\",
					`isApproved` 	=	\"".$this->model->getIsApproved('','single')."\"
			WHERE 	`eventId`		=	\"". $this->model->getEventId('','single')."\"";
		}
		$this->q->update($sql);
		$this->q->commit();
	}
	/* (non-PHPdoc)
	 * @see configClass::delete()
	 */
	function delete()
	{
		header('Content-type: application/json');
		$this->model->delete();
		$this->q->start();
		if($this->getVendor() == self::mysql){
			$sql = "
			UPDATE	`event`
			SET		`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
					`isNew`			=	\"".$this->model->getIsNew('','single')."\",
					`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
					`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
					`isActive`		= 	\"".$this->model->getIsActive('','single')."\",
					`isApproved` 	=	\"".$this->model->getIsApproved('','single')."\"
			WHERE 	`eventId`		=	\"". $this->model->getEventId('','single')."\"";
		} else if ($this->q->vendor == self :: mssql){
			$sql = "
			UPDATE	[event]
			SET		[isDefault]		=	\"".$this->model->getIsDefault('','single')."\",
					[isNew]			=	\"".$this->model->getIsNew('','single')."\",
					[isDraft]		=	\"".$this->model->getIsDraft('','single')."\",
					[isUpdate]		=	\"".$this->model->getIsUpdate('','single')."\",
					[isActive]		= 	\"".$this->model->getIsActive('','single')."\",
					[isApproved] 	=	\"".$this->model->getIsApproved('','single')."\"
			WHERE 	[eventId]		=	\"". $this->model->getEventId('','single')."\"";
		} else if ($this->q->vendor == self:: oracle){
			$sql = "
			UPDATE	`event`
			SET		`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
					`isNew`			=	\"".$this->model->getIsNew('','single')."\",
					`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
					`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
					`isActive`		= 	\"".$this->model->getIsActive('','single')."\",
					`isApproved` 	=	\"".$this->model->getIsApproved('','single')."\"
			WHERE 	`eventId`		=	\"". $this->model->getEventId('','single')."\"";
		}
		$this->q->update($sql);
		$this->q->commit();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{
	}
}
$eventObject = new eventClass();

if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$eventObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST['isAdmin'])) {
		$eventObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$eventObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$eventObject->create();
	}
	if ($_POST['method'] == 'read') {
		$eventObject->read();
	}
	if ($_POST['method'] == 'update') {
		$eventObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$eventObject->delete();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET['leafId'])) {
		$eventObject->setLeafId($_GET['leafId']);
	}
	if (isset($_GET['isAdmin'])) {
		$eventObject->setLeafId($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$eventObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$eventObject->staff();
		}
	}
}

?>

