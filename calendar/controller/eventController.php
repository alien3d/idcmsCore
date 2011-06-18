<?php
session_start();
require_once("../../class/classAbstract.php");
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
        $this->q->connect($this->connection, $this->username, $this->database, $this->password);
        $this->excel  = new PHPExcel();
        $this->audit  = 0;
        $this->log    = 0;
        $this->q->log = $this->log;
        $this->model  = new eventModel();
    }
    /* (non-PHPdoc)
     * @see configClass::create()
     */
    public function create()
    {
        header('Content-type: application/json');
        $this->model->create();
        $this->q->start();
        if ($this->getVendor() == self::mysql || $this->q->vendor == 'normal') {
        } else if ($this->getVendor() ==  self::mssql)
            $sql = "
					INSERT INTO `event`
							(
								`calendarId`,
								`calenderTitle`,
								`calendarStart`,
								`calendarEnd`,
								`calendarAd`,
								`calendarNotes`,
								`calenderRem`,
								`calenderUrl`,
								`calenderLoc`,
								`calendearN`,
								`staffId`,
								`isNew`
								`isDraft`,
								`isUpdate`,
								`isDelete`,
								`By`,
								`Time`
							)
					VALUES	(
								'" . $this->strict($_POST['calendar_uniqueId'], 'n') . "',
								'" . $this->strict($_POST['title'], 's') . "',
								'" . date("Y-m-d H:i:s", strtotime($_POST['start'])) . "',
								'" . date("Y-m-d H:i:s", strtotime($_POST['end'])) . "',
								'" . $this->strict($_POST['ad'], 'c') . "',
								'" . $this->strict($_POST['notes'], 's') . "',
								'" . $this->strict($_POST['rem'], 'c') . "',
								'" . $this->strict($_POST['url'], 'c') . "',
								'" . $this->strict($_POST['loc'], 's') . "',
								'" . $this->strict($_POST['n'], 'c') . "',
								'" . $_SESSION['staff_uniqueId'] . "'
							);";
        $this->q->create($sql);
        $this->q->commit();
    }
    /* (non-PHPdoc)
     * @see configClass::read()
     */
    public function read()
    {
        header('Content-type: application/json');
        $sql = "
				SELECT	*
				FROM 	`event`
				JOIN    `calendarColor`
				USING   (`calendarColorId`)
				WHERE 	1
				AND     `calendar`.`staffId` = '" . $this->staffId . "'";
        $this->q->read($sql);
        $total = $this->q->numberRows();
        $items = array();
        while ($row = $this->q->fetchAssoc()) {
            $items[] = $row;
        }
        echo json_encode(array(
            'evts' => $items
        ));
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
					SET 	`calendarId`	=	'" . $this->strict($_POST['calendar_uniqueId'], 'n') . "',
							`eventTitle`	=	'" . $this->strict($_POST['title'], 's') . "',
							`eventStart`	=	'" . date("Y-m-d H:i:s", strtotime($_POST['start'])) . "',
							`eventEnd`	=	'" . date("Y-m-d H:i:s", strtotime($_POST['end'])) . "',
							`eventAddress`    = 	'" . $this->strict($_POST['ad'], 'c') . "',
							`EventNotes` = 	'" . $this->strict($_POST['notes'], 's') . "',
							`eventReminder`	=	'" . $this->strict($_POST['rem'], 'c') . "',
							`eventUrl`	=	'" . $this->strict($_POST['url'], 'c') . "',
							`eventLocation`	=	'" . $this->strict($_POST['loc'], 's') . "',
							`eventN`	=	'" . $this->strict($_POST['n'], 'c') . "'
					WHERE 	`eventId`		=	'" . $this->strict($_POST['eventId'], 'n') . "'";
     if($this->getVendor() == self::mysql){
        $sql = "
			UPDATE	`event`
			SET
					`calendarId`	=	'".$this->model->getC."',
					`isDefault`		=	'".$this->model->getIsDefault('','string')."',
					`isNew`			=	'".$this->model->getIsNew('','string')."',
					`isDraft`		=	'".$this->model->getIsDraft('','string')."',
					`isUpdate`		=	'".$this->model->getIsUpdate('','string')."',
					`isActive`		= 	'".$this->model->getIsActive('','string')."',
					`isApproved` 	=	'".$this->model->getIsApproved('','string')."'
			WHERE 	`eventId`		=	'" . $this->model->getEventId('','string'). "'";
        } else if ($this->q->vendor == self :: mssql){
        	$sql = "
			UPDATE	[event]
			SET		[isDefault]		=	'".$this->model->getIsDefault('','string')."',
					[isNew]			=	'".$this->model->getIsNew('','string')."',
					[isDraft]		=	'".$this->model->getIsDraft('','string')."',
					[isUpdate]		=	'".$this->model->getIsUpdate('','string')."',
					[isActive]		= 	'".$this->model->getIsActive('','string')."',
					[isApproved] 	=	'".$this->model->getIsApproved('','string')."'
			WHERE 	[eventId]		=	'" . $this->model->getEventId('','string'). "'";
        } else if ($this->q->vendor == self:: oracle){
        	$sql = "
			UPDATE	`event`
			SET		`isDefault`		=	'".$this->model->getIsDefault('','string')."',
					`isNew`			=	'".$this->model->getIsNew('','string')."',
					`isDraft`		=	'".$this->model->getIsDraft('','string')."',
					`isUpdate`		=	'".$this->model->getIsUpdate('','string')."',
					`isActive`		= 	'".$this->model->getIsActive('','string')."',
					`isApproved` 	=	'".$this->model->getIsApproved('','string')."'
			WHERE 	`eventId`		=	'" . $this->model->getEventId('','string'). "'";
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
			SET		`isDefault`		=	'".$this->model->getIsDefault('','string')."',
					`isNew`			=	'".$this->model->getIsNew('','string')."',
					`isDraft`		=	'".$this->model->getIsDraft('','string')."',
					`isUpdate`		=	'".$this->model->getIsUpdate('','string')."',
					`isActive`		= 	'".$this->model->getIsActive('','string')."',
					`isApproved` 	=	'".$this->model->getIsApproved('','string')."'
			WHERE 	`eventId`		=	'" . $this->model->getEventId('','string'). "'";
        } else if ($this->q->vendor == self :: mssql){
        	$sql = "
			UPDATE	[event]
			SET		[isDefault]		=	'".$this->model->getIsDefault('','string')."',
					[isNew]			=	'".$this->model->getIsNew('','string')."',
					[isDraft]		=	'".$this->model->getIsDraft('','string')."',
					[isUpdate]		=	'".$this->model->getIsUpdate('','string')."',
					[isActive]		= 	'".$this->model->getIsActive('','string')."',
					[isApproved] 	=	'".$this->model->getIsApproved('','string')."'
			WHERE 	[eventId]		=	'" . $this->model->getEventId('','string'). "'";
        } else if ($this->q->vendor == self:: oracle){
        	$sql = "
			UPDATE	`event`
			SET		`isDefault`		=	'".$this->model->getIsDefault('','string')."',
					`isNew`			=	'".$this->model->getIsNew('','string')."',
					`isDraft`		=	'".$this->model->getIsDraft('','string')."',
					`isUpdate`		=	'".$this->model->getIsUpdate('','string')."',
					`isActive`		= 	'".$this->model->getIsActive('','string')."',
					`isApproved` 	=	'".$this->model->getIsApproved('','string')."'
			WHERE 	`eventId`		=	'" . $this->model->getEventId('','string'). "'";
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
if (isset($_SESSION['staffId'])) {
    $eventObject->setStaffId($_SESSION['staffId']);
}
if (isset($_SESSION['vendor'])) {
    $eventObject->setVendor($_SESSION['vendor']);
}
if (isset($_SESSION['languageId'])) {
    $eventObject->setLanguageId($_SESSION['languageId']);
}
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
    if ($_POST['method'] == 'raed') {
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

