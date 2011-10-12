<?php
class RecordSet {
	private $vendor;
	/**
	* Mysql Database (open Core)
	* @var const string
	*/
	const MYSQL = 'mysql';
	/**
	* Microsoft Sql Server Database (Close Source)
	* @var const string
	*/
	const MSSQL = 'microsoft';
	/**
	* Oracle Database (Close  Source)
	* @var const string
	*/
	const ORACLE = 'oracle';
	/**
	* Database DB2 IBM ( Close Source)
	* @var const string
	*/
	const DB2 = 'db2';
	/**
	* Postgress (Open Source)
	* @var const string
	*/
	const POSTGRESS = 'postgress';
	/**
	* Cubrid Database ? korean database
	 * @var const string
	 */
	 const CUBRID = 'cubrid';
	 /**
	 * Firebird / Interbase
	 * @var const string
	 */
	 const IBASE = 'ibase';
	 // end basic access database
	public function execute(){
		
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
	SELECT 	MIN(`" . $this->model->getPrimaryKeyName () . "`) AS `firstRecord`
	FROM 	`" . $this->model->getTableName () . "`";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
	SELECT 	MIN([" . $this->model->getPrimaryKeyName () . "]) AS [firstRecord]
	FROM 	[" . $this->model->getTableName () . "]";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
	SELECT 	MIN(" . strtoupper ( $this->model->getPrimaryKeyName () ) . ") AS \"firstRecord\"
	FROM 	" . strtoupper ( $this->model->getTableName () ) . " ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result );
		if ($total > 0) {
			$row = $this->q->fetchAssoc ( $result );
			$firstRecord = $row ['firstRecord'];
		} else {
			$firstRecord = 0;
		}
		if ($value == 'value') {
			return intval ( $firstRecord );
		} else {
			$json_encode = json_encode ( array ('success' => TRUE, 'total' => $total, 'firstRecord' => $firstRecord ) );
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
		SELECT (`" . $this->model->getPrimaryKeyName () . "`) AS `nextRecord`
		FROM 	`" . $this->model->getTableName () . "`
		WHERE 	`" . $this->model->getPrimaryKeyName () . "` > " . $primaryKeyValue . "
		LIMIT 	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT  TOP 1 ([" . $this->model->getPrimaryKeyName () . "]) AS [nextRecord]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE 	[" . $this->model->getPrimaryKeyName () . "] > " . $primaryKeyValue . " ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT (" . strtoupper ( $this->model->getPrimaryKeyName () ) . ") AS \"nextRecord\"
							FROM 	" . strtoupper ( $this->model->getTableName () ) . "
							WHERE 	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " > " . $primaryKeyValue . "
			AND		ROWNUM = 1";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numbersRows ( $result );
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
			SELECT (`" . $this->model->getPrimaryKeyName () . "`) AS `previousRecord`
					FROM 	`" . $this->model->getTableName () . "`
					WHERE 	`" . $this->model->getPrimaryKeyName () . "` < " . $primaryKeyValue . "
					LIMIT 	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
						SELECT TOP 1 ([" . $this->model->getPrimaryKeyName () . "]) AS [previousRecord]
						FROM 	[" . $this->model->getTableName () . "]
						WHERE 	[" . $this->model->getPrimaryKeyName () . "] < " . $primaryKeyValue . " ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
						SELECT (" . strtoupper ( $this->model->getPrimaryKeyName () ) . ") AS \"previous\"
						FROM 	" . strtoupper ( $this->model->getTableName () ) . "
							WHERE 	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " < " . $primaryKeyValue . "
										AND 	ROWNUM  = 1
										";
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
							SELECT	MAX(`" . $this->model->getPrimaryKeyName () . "`) AS `lastRecord`
									FROM 	`" . $this->model->getTableName () . "`";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
									SELECT	MAX([" . $this->model->getPrimaryKeyName () . "]) AS [lastRecord]
							FROM 	[" . $this->model->getTableName () . "]";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
								SELECT	MAX(" . $this->model->getPrimaryKeyName () . ") AS \"lastRecord\"
								FROM 	" . strtoupper ( $this->model->getTableName () ) . " ";
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
	 * @return the $vendor
	 */
	public function getVendor() {
		return $this->vendor;
	}

	/**
	 * @param field_type $vendor
	 */
	public function setVendor($vendor) {
		$this->vendor = $vendor;
	}

}