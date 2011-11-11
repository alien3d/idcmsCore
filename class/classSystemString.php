<?php
/**
 * Response Message if any error
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
	 * Create New Record Message
	 * @var string
	 */
	private $createMessage;
	/**
	 * Read / Load Message
	 * @var string
	 */
	private $readMessage;
	/**
	 * Update Message
	 * @var string
	 */
	private $updateMessage;
	/**
	 * Delete Message
	 * @var string
	 */
	private $deleteMessage;
	/**
	 * Duplicate Code MEssage
	 * @var string
	 */
	private $duplicateMessage;
	/**
	 * Non Duplicate Code Message
	 * @var string
	 */
	private $nonDuplicateMessage;
	/**
	 * Not Supported Database
	 * @var string
	 */
	private $nonSupportedDatabase;
	/**
	 * File Found Message
	 * @var string
	 */
	private $fileFound;
	/**
	 * File Not Found Message
	 * @var string
	 */
	private $fileNotFound;
	/**
	 * Record Not Found Message
	 * @var string
	 */
	private $recordNotFound;
	
	// end basic access database
	public function execute() {
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		$sql="SELECT * FROM `systemStringTranslate` WHERE `languageId`='".$this->getLanguageId()."'";
		$result = $this->q->fast($sql);
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
					$this->setFileFound($row['systemStringNative']);
					break;
				case 'fileNotFound':
					$this->setFileFound($row['systemStringNative']);
					break;
				case 'nonSupportedDatabase':
					$this->setNonSupportedDatabase($row['systemStringNative']);
					break;
				case 'recordNotFound':
					$this->setRecordNotFound($row['systemStringNative']);
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
	 * Return Create Message
	 * @return string
	 */
	public function getCreateMessage()
	{
		return $this->createMessage;
	}

	/**
	 * Set Create Message
	 * @param string $createMessage
	 */
	public function setCreateMessage($createMessage)
	{
		$this->createMessage = $createMessage;
	}

	/**
	 * Return Read Message
	 * @return string
	 */
	public function getReadMessage()
	{
		return $this->readMessage;
	}

	/**
	 * Set Read Message
	 * @param string $readMessage
	 */
	public function setReadMessage($readMessage)
	{
		$this->readMessage = $readMessage;
	}

	/**
	 * Return Update Message
	 * @return string
	 */
	public function getUpdateMessage()
	{
		return $this->updateMessage;
	}

	/**
	 * Set Update Message
	 * @param string $updateMessage
	 */
	public function setUpdateMessage($updateMessage)
	{
		$this->updateMessage = $updateMessage;
	}

	/**
	 * Return  Delete Message
	 * @return string
	 */
	public function getDeleteMessage()
	{
		return $this->deleteMessage;
	}

	/**
	 * Set Delete Message
	 * @param string $deleteMessage
	 */
	public function setDeleteMessage($deleteMessage)
	{
		$this->deleteMessage = $deleteMessage;
	}

	/**
	 * Set Duplicate Code Message
	 * @return string
	 */
	public function getDuplicateMessage()
	{
		return $this->duplicateMessage;
	}

	/**
	 * Set Duplicate Code Message
	 * @param string $duplicateMessage
	 */
	public function setDuplicateMessage($duplicateMessage)
	{
		$this->duplicateMessage = $duplicateMessage;
	}

	/**
	 * Return Non  Duplicate Code Message
	 * @return string
	 */
	public function getNonDuplicateMessage()
	{
		return $this->nonDuplicateMessage;
	}

	/**
	 * Set Non Duplicate Code Message
	 * @param string $nonDuplicateMessage
	 */
	public function setNonDuplicateMessage($nonDuplicateMessage)
	{
		$this->nonDuplicateMessage = $nonDuplicateMessage;
	}

	/**
	 * Return Non Supported Database
	 * @return string
	 */
	public function getNonSupportedDatabase()
	{
		return $this->nonSupportedDatabase;
	}

	/**
	 * Set Non Supported Database
	 * @param string $nonSupportedDatabase
	 */
	public function setNonSupportedDatabase($nonSupportedDatabase)
	{
		$this->nonSupportedDatabase = $nonSupportedDatabase;
	}

	/**
	 * Return File Not Found Message
	 * @return string
	 */
	public function getFileFound()
	{
		return $this->fileFound;
	}

	/**
	 * Set File  Found Message
	 * @param string $fileFound
	 */
	public function setFileFound($fileFound)
	{
		$this->fileFound = $fileFound;
	}

	/**
	 * Return File Not Found Message
	 * @return string
	 */
	public function getFileNotFound()
	{
		return $this->fileNotFound;
	}

	/**
	 * Set File Not Found Message
	 * @param string $fileNotFound
	 */
	public function setFileNotFound($fileNotFound)
	{
		$this->fileNotFound = $fileNotFound;
	}

	public function getRecordNotFound()
	{
	    return $this->recordNotFound;
	}

	public function setRecordNotFound($recordNotFound)
	{
	    $this->recordNotFound = $recordNotFound;
	}
}