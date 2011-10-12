<?php
/**
 *Adodb Like function query .. moveFirst-> firstRecord,moveNext ->nextRecord,movePrevious->previousRecord,moveLast->lastRecord
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package RecordSet
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class RecordSet extends ConfigClass {
	private $q;
	private $PrimaryKeyName;
	private $TableName;
	// end basic access database
	public function execute() {
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
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
	 * Return The First Record
	 * params @value . This return data type. When call by normal read.Value=='value'.When requested by ajax request button Value=='json'
	 * @return int
	 */
	public function firstRecord($value) {
		$first = 0;
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
	SELECT 	MIN(`" . $this->getPrimaryKeyName () . "`) AS `firstRecord`
	FROM 	`" . $this->getTableName () . "`";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
	SELECT 	MIN([" . $this->getPrimaryKeyName () . "]) AS [firstRecord]
	FROM 	[" . $this->getTableName () . "]";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
	SELECT 	MIN(" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"firstRecord\"
	FROM 	" . strtoupper ( $this->getTableName () ) . " ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT 	MIN(" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"firstRecord\"
			FROM 	" . strtoupper ( $this->getTableName () ) . " ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT 	MIN(" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"firstRecord\"
			FROM 	" . strtoupper ( $this->getTableName () ) . " ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows($result);
		if ($total > 0) {
			$row = $this->q->fetchAssoc ( $result );
			$firstRecord = $row ['firstRecord'];
		} else {
			$firstRecord = 0;
		}
		if ($value == 'value') {
			return intval ( $firstRecord );
		} else {
			$json_encode = json_encode ( array ('success' => true, 'total' => $total, 'firstRecord' => $firstRecord ) );
			exit ();
		}
	}
	/**
	 * Return Next record
	 * @param int $primaryKeyValue
	 * @return int
	 */
	public function nextRecord($value, $primaryKeyValue) {
		$next = 0;
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT (`" . $this->getPrimaryKeyName () . "`) AS `nextRecord`
		FROM 	`" . $this->getTableName () . "`
		WHERE 	`" . $this->getPrimaryKeyName () . "` > " . $primaryKeyValue . "
		LIMIT 	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT  TOP 1 ([" . $this->getPrimaryKeyName () . "]) AS [nextRecord]
		FROM 	[" . $this->getTableName () . "]
		WHERE 	[" . $this->getPrimaryKeyName () . "] > " . $primaryKeyValue . " ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT (" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"nextRecord\"
							FROM 	" . strtoupper ( $this->getTableName () ) . "
							WHERE 	" . strtoupper ( $this->getPrimaryKeyName () ) . " > " . $primaryKeyValue . "
			AND		ROWNUM = 1";
		} else if ($this->getVendor () == self::DB2) {
		
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT (`" . $this->getPrimaryKeyName () . "`) AS `nextRecord`
			FROM 	`" . $this->getTableName () . "`
			WHERE 	`" . $this->getPrimaryKeyName () . "` > " . $primaryKeyValue . "
			LIMIT 	1";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result );
		if ($total > 0) {
			$row = $this->q->fetchAssoc ( $result );
			$nextRecord = $row ['nextRecord'];
		} else {
			$nextRecord = 0;
		}
		if ($value == 'value') {
			return intval ( $nextRecord );
		} else {
			$json_encode = json_encode ( array ('success' => TRUE, 'total' => $total, 'nextRecord' => $nextRecord ) );
			exit ();
		}
	}
	/**
	 * Return Previous Record
	 * @param int $primaryKeyValue
	 * @return int
	 */
	public function previousRecord($value, $primaryKeyValue) {
		$previous = 0;
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT (`" . $this->getPrimaryKeyName () . "`) AS `previousRecord`
					FROM 	`" . $this->getTableName () . "`
					WHERE 	`" . $this->getPrimaryKeyName () . "` < " . $primaryKeyValue . "
					ORDER BY `". $this->getPrimaryKeyName ()."` DESC
					LIMIT 	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
						SELECT TOP 1 ([" . $this->getPrimaryKeyName () . "]) AS [previousRecord]
						FROM 	[" . $this->getTableName () . "]
						WHERE 	[" . $this->getPrimaryKeyName () . "] < " . $primaryKeyValue . " ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
						SELECT (" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"previous\"
						FROM 	" . strtoupper ( $this->getTableName () ) . "
							WHERE 	" . strtoupper ( $this->getPrimaryKeyName () ) . " < " . $primaryKeyValue . "
										AND 	ROWNUM  = 1
										";
		} else if ($this->getVendor () == self::DB2) {
		
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT (`" . $this->getPrimaryKeyName () . "`) AS `previousRecord`
			FROM 	`" . $this->getTableName () . "`
			WHERE 	`" . $this->getPrimaryKeyName () . "` < " . $primaryKeyValue . "
			LIMIT 	1";
		
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result );
		if ($total > 0) {
			$row = $this->q->fetchAssoc ( $result );
			$previousRecord = $row ['previousRecord'];
		} else {
			$previousRecord = 0;
		}
		if ($value == 'value') {
			return intval ( $previousRecord );
		} else {
			$json_encode = json_encode ( array ('success' => TRUE, 'total' => $total, 'previousRecord' => $previousRecord ) );
			exit ();
		}
	}
	/**
	 * Return Last Record
	 * @return int
	 */
	public function lastRecord($value) {
		$lastRecord = 0;
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
							SELECT	MAX(`" . $this->getPrimaryKeyName () . "`) AS `lastRecord`
									FROM 	`" . $this->getTableName () . "`";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
									SELECT	MAX([" . $this->getPrimaryKeyName () . "]) AS [lastRecord]
							FROM 	[" . $this->getTableName () . "]";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
								SELECT	MAX(" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"lastRecord\"
								FROM 	" . strtoupper ( $this->getTableName () ) . " ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT	MAX(" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"lastRecord\"
			FROM 	" . strtoupper ( $this->getTableName () ) . " ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	MAX(" . strtoupper ( $this->getPrimaryKeyName () ) . ") AS \"lastRecord\"
			FROM 	" . strtoupper ( $this->getTableName () ) . " ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result );
		if ($total > 0) {
			$row = $this->q->fetchAssoc ( $result );
			$lastRecord = $row ['lastRecord'];
		} else {
			$lastRecord = 0;
		}
		if ($value == 'value') {
			return intval ( $lastRecord );
		} else {
			$json_encode = json_encode ( array ('success' => TRUE, 'total' => $total, 'lastRecord' => $lastRecord ) );
			exit ();
		}
	}
	/**
	 * @return the $PrimaryKeyName
	 */
	public function getPrimaryKeyName() {
		return $this->PrimaryKeyName;
	}
	
	/**
	 * @return the $TableName
	 */
	public function getTableName() {
		return $this->TableName;
	}
	
	/**
	 * @param field_type $PrimaryKeyName
	 */
	public function setPrimaryKeyName($PrimaryKeyName) {
		$this->PrimaryKeyName = $PrimaryKeyName;
	}
	
	/**
	 * @param field_type $TableName
	 */
	public function setTableName($TableName) {
		$this->TableName = $TableName;
	}

}