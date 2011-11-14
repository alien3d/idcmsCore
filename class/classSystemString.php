<?php
/**
 * Response  if any error
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package System String Response
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class SystemString  extends ConfigClass {
	private $q;
	/**
	 * Create New Record
	 * @var string
	 */
	private $createMessage;
	/**
	 * Read / Load
	 * @var string
	 */
	private $readMessage;
	/**
	 * Update
	 * @var string
	 */
	private $updateMessage;
	/**
	 * Delete
	 * @var string
	 */
	private $deleteMessage;
	/**
	 * Duplicate Code Message
	 * @var string
	 */
	private $duplicateMessage;
	/**
	 * Non Duplicate Code
	 * @var string
	 */
	private $nonDuplicateMessage;
	/**
	 * Not Supported Database
	 * @var string
	 */
	private $nonSupportedDatabaseMessage;
	/**
	 * File Found
	 * @var string
	 */
	private $fileFoundMessage;
	/**
	 * File Not Found
	 * @var string
	 */
	private $fileNotFoundMessage;
	/**
	 * Record Not Found
	 * @var string
	 */
	private $recordFoundMessage;
	/**
	 * Record Not Found
	 * @var string
	 */
	private $recordNotFoundMessage;

	// end basic access database
	public function execute() {
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		if($this->getVendor()==self::MYSQL){
			$sql="
			SELECT  `systemStringTranslate`.`systemStringCode`,
					`systemStringTranslate`.`systemStringNative`
			FROM 	`systemStringTranslate`
			WHERE	`systemStringTranslate`.`languageId`='".$this->getLanguageId()."'";
		} else if ($this->getVendor()==self::MSSQL){
			$sql="
			SELECT  [systemStringTranslate].[systemStringCode],
					[systemStringTranslate].[systemStringNative]
			FROM 	[systemStringTranslate]
			WHERE	[systemStringTranslate].[languageId]='".$this->getLanguageId()."'";
		} else if ($this->getVendor()==self::ORACLE){
			$sql="
			SELECT  SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGCODE,
					SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGNATIVE
			FROM 	SYSTEMSTRINGTRANSLATE
			ON		SYSTEMSTRING.SYSTEMSTRINGID=SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGID 
			WHERE	SYSTEMSTRINGTRANSLATE.LANGUAGEID='".$this->getLanguageId()."'";
		} else if ($this->getVendor()==self::DB2){
			$sql="
			SELECT  SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGCODE,
					SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGNATIVE
			FROM 	SYSTEMSTRINGTRANSLATE
			WHERE	SYSTEMSTRINGTRANSLATE.LANGUAGEID='".$this->getLanguageId()."'";
		} else if ($this->getVendor()==self::POSTGRESS){
			$sql="
			SELECT  SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGCODE,
					SYSTEMSTRINGTRANSLATE.SYSTEMSTRINGNATIVE
			FROM 	SYSTEMSTRINGTRANSLATE
			WHERE	SYSTEMSTRINGTRANSLATE.LANGUAGEID='".$this->getLanguageId()."'";
		}
		$result = $this->q->fast($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		while ($row = $this->q->fetchArray($result)) {
			switch($row['systemStringCode']){
				case 'create':
					$this->setCreateMessage($row['systemStringNative']);
					break;
				case 'read':
					$this->setReadMessage($row['systemStringNative']);
					break;
				case 'update':
					$this->setUpdateMessage($row['systemStringNative']);
					break;
				case 'delete':
					$this->setDeleteMessage($row['systemStringNative']);
					break;
				case 'duplicate':
					$this->setDuplicateMessage($row['systemStringNative']);
					break;
				case 'notDuplicate':
					$this->setNonDuplicateMessage($row['systemStringNative']);
					break;
				case 'fileFound':
					$this->setFileFoundMessage($row['systemStringNative']);
					break;
				case 'fileNotFound':
					$this->setFileFoundMessage($row['systemStringNative']);
					break;
				case 'recordFound':
					$this->setRecordFoundMessage($row['systemStringNative']);
					break;
				case 'recordNotFound':
					$this->setRecordNotFoundMessage($row['systemStringNative']);
					break;
				case 'nonSupportedDatabase':
					$this->setNonSupportedDatabaseMessage($row['systemStringNative']);
					break;

			}
		}
	}

	public function create() {
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() {
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update() {
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete() {
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel() {
	}



	/**
	 * Return Create
	 * @return string
	 */
	public function getCreateMessage()
	{
		return $this->createMessage;
	}

	/**
	 * Set Create
	 * @param string $createMessage
	 */
	public function setCreateMessage($createMessage)
	{
		$this->createMessage = $createMessage;
	}

	/**
	 * Return Read
	 * @return string
	 */
	public function getReadMessage()
	{
		return $this->readMessage;
	}

	/**
	 * Set Read
	 * @param string $readMessage
	 */
	public function setReadMessage($readMessage)
	{
		$this->readMessage = $readMessage;
	}

	/**
	 * Return Update
	 * @return string
	 */
	public function getUpdateMessage()
	{
		return $this->updateMessage;
	}

	/**
	 * Set Update
	 * @param string $updateMessage
	 */
	public function setUpdateMessage($updateMessage)
	{
		$this->updateMessage = $updateMessage;
	}

	/**
	 * Return  Delete
	 * @return string
	 */
	public function getDeleteMessage()
	{
		return $this->deleteMessage;
	}

	/**
	 * Set Delete
	 * @param string $deleteMessage
	 */
	public function setDeleteMessage($deleteMessage)
	{
		$this->deleteMessage = $deleteMessage;
	}

	/**
	 * Set Duplicate Code
	 * @return string
	 */
	public function getDuplicateMessage()
	{
		return $this->duplicateMessage;
	}

	/**
	 * Set Duplicate Code
	 * @param string $duplicate
	 */
	public function setDuplicateMessage($duplicateMessage)
	{
		$this->duplicateMessage = $duplicateMessage;
	}

	/**
	 * Return Non  Duplicate Code
	 * @return string
	 */
	public function getNonDuplicateMessage()
	{
		return $this->nonDuplicateMessage;
	}

	/**
	 * Set Non Duplicate Code
	 * @param string $nonDuplicate
	 */
	public function setNonDuplicateMessage($nonDuplicateMessage)
	{
		$this->nonDuplicateMessage = $nonDuplicateMessage;
	}

	/**
	 * Return Non Supported Database
	 * @return string
	 */
	public function getNonSupportedDatabaseMessage()
	{
		return $this->nonSupportedDatabaseMessage;
	}

	/**
	 * Set Non Supported Database
	 * @param string $nonSupportedDatabase
	 */
	public function setNonSupportedDatabaseMessage($nonSupportedDatabaseMessage)
	{
		$this->nonSupportedDatabaseMessage = $nonSupportedDatabaseMessage;
	}

	/**
	 * Return File Not Found
	 * @return string
	 */
	public function getFileFoundMessage()
	{
		return $this->fileFoundMessage;
	}

	/**
	 * Set File  Found
	 * @param string $fileFoundMessage
	 */
	public function setFileFoundMessage($fileFoundMessage)
	{
		$this->fileFoundMessage = $fileFoundMessage;
	}

	/**
	 * Return File Not Found
	 * @return string
	 */
	public function getFileNotFoundMessage()
	{
		return $this->fileNotFoundMessage;
	}

	/**
	 * Set File Not Found
	 * @param string $fileNotFoundMessage
	 */
	public function setFileNotFoundMessage($fileNotFoundMessage)
	{
		$this->fileNotFoundMessage = $fileNotFoundMessage;
	}
	/**
	 * Return Record Found
	 * @return string
	 */
	public function getRecordFoundMessage()
	{
		return $this->recordFoundMessage;
	}

	/**
	 * Set Record  Found
	 * @param string $recordFoundMessage
	 */
	public function setRecordFoundMessage($recordFoundMessage)
	{
		$this->recordFoundMessage = $recordFoundMessage;
	}
	/**
	 * Return Record Not Found
	 * @return string
	 */
	public function getRecordNotFoundMessage()
	{
		return $this->recordNotFoundMessage;
	}
	/**
	 * Set Record Not Found
	 * @param string $recordNotFoundMessage
	 */
	public function setRecordNotFoundMessage($recordNotFoundMessage)
	{
		$this->recordNotFoundMessage = $recordNotFoundMessage;
	}
}