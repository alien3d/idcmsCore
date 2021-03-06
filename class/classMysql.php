<?php
/**
 * a specific class for connection to mysql.Either mysql or mysqli
 * @author hafizan
 * @copyright IDCMS
 * @version 1.0
 * @version 1.1 new support for Microsoft Sql Server. 02/12/2011
 * @version 1.2 new support for Oracle 02/15/2011
 * @version 1.3 change for provider to vendor instead of mysqldb
 */
class Vendor {
	// private property
	/**
	 * Connection
	 * @var string
	 */
	private $connection;
	/**
	 * Username
	 * @var string
	 */
	private $username;
	/**
	 * Database Name
	 * @var string
	 */
	private $databaseName;
	/**
	 * Sql Statement Operation
	 * @var string
	 */
	private $operation;
	/**
	 * Database Port .Default 3306
	 * @var string
	 */
	private $port;
	/**
	 * sql statement
	 * @var string
	 */
	private $socket;
	// public property


	/**
	 * sql statement
	 * @var string
	 */
	public $sql;
	/**
	 * link resources
	 * @var result
	 */
	public $link;
	/**
	 * result statement
	 * @var result
	 */
	public $result;
	/**
	 * tablename for advance loging purpose
	 * @var string
	 */
	public $tableName;
	/**
	 * primary key  for advance loging purpose
	 * @var string
	 */
	public $primaryKeyName;
	/**
	 * primary key value for advance loging purpose
	 * @var string
	 */
	public $primaryKeyValue;
	/**
	 * tablename for advance loging purpose
	 * @var string
	 */
	public $columnName;
	/**
	 * Date Filtering Type.E.g Day,Week,Month,Year,Between
	 * @var string
	 */
	public $dateFilterTypeQuery;
	/**
	 * Date Filtering Start
	 * @var date
	 */
	public $startDate;
	/**
	 * Date Filtering End
	 * @var date
	 */
	public $endDate;

	/**
	 * Audit Row Trail  1 Audit  0 for not
	 * @var boolean $audit
	 */
	public $audit;
	/**
	 * Audit Log 1 Audit 0 for not
	 * @var boolean $log
	 */
	public $log;
	/**
	 * per page record
	 * @var number
	 */
	public $offset;
	/**
	 * per page record
	 * @var number
	 */
	public $limit;
	/**
	 * ver Mysql,Mysqli,Oracle,Sql Server
	 * @var string
	 */
	public $vendor;
	/**
	 * total record
	 * @var number
	 */
	public $countRecord;
	public $sorting;
	/**
	 * program id
	 * @var numeric
	 */
	public $leafId;
	/**
	 * Database Responce if any query fail
	 * @var string
	 */
	public $responce;
	/**
	 * to inform user if error
	 * @var string $execute
	 */
	public $execute;
	/**
	 * Extjs Field Query UX
	 * @var string $fieldQuery
	 */
	public $fieldQuery;
	/**
	 * Extjs Grid  Filter Plugin
	 * @var string $gridQuery
	 */
	public $gridQuery;
	/**
	 * Staff Identification
	 * @var numeric $staffId
	 */
	public $staffId;
	/**
	 * predefine commit constructor for oracle database extension
	 */
	public $oracleCommit = 0;
	/***
	 *  @var int
	 */
	public $insertId;
	/**
	 *  Core database
	 *  @var string
	 */
	public $coreDatabase;
	/**
	 *  Audit Trail Log (Sql Version)
	 *  @var string
	 */
	public $logDatabase;
	/**
	 *  Financial Database
	 *  @var string
	 */
	public $financialDatabase;
	/**
	 *  Fix Asset Database
	 *  @var string
	 */
	public $fixAssetDatabase;
	/**
	 *  Payroll Database
	 *  @var string
	 */
	public $payrollDatabase;
	/**
	 *  Human Resources Database
	 *  @var string
	 */
	public $humanResourcesDatabase;
	/**
	 *  Common Database
	 *  @var string
	 */
	public $commonDatabase;
	/**
	 *  Management Database
	 *  @var string
	 */
	public $managementDatabase;



	public function __construct() {
	}
	/**
	 * To connect mysql database
	 * @param string $connection
	 *
	 * The MySQL server. It can also include a port number. e.g. "hostname:port" or a path to a local socket e.g. ":/path/to/socket" for the localhost.
	 If the PHP directive mysql.default_host is undefined (default),
	 then the default value is 'localhost:3306'.
	 In SQL safe mode, this parameter is ignored and value 'localhost:3306' is always used.
	 * @param string $username
	 * The username. Default value is defined by mysql.default_user. In SQL safe mode, this parameter is ignored and the name of the user that owns the server process is used.
	 * @param string $database
	 * The name of the database that is to be selected.
	 * @param string $password
	 * The password. Default value is defined by mysql.default_password. In SQL safe mode, this parameter is ignored and empty password is used
	 */
	public function connect($connection, $username, $database, $password) {
		$this->connection = $connection;
		$this->username = $username;
		/**
		 * @depreciated
		 */
		//$this->databaseName = $database;
		/**
		 * Overide above using core database.
		 */
		$this->setCoreDatabase('iCore');
		$this->setFinancialDatabase('iFinancial');
		$this->setFixAssetDatabase('ifixAsset');
		$this->setPayrollDatabase('ipayroll');
		$this->setHumanResourcesDatabase('ihumanResources');
		$this->setManagementDatabase('imanagement');
		$this->setCommonDatabase('icommon');
		$this->setLogDatabase('ilog');
		$this->databaseName  = $this->coreDatabase;  // overide above
		$this->password = $password;
		$this->link = mysqli_connect ( $this->connection, $this->username, $this->password, $this->databaseName, $this->port, $this->socket );
		if (! $this->link) {
			$this->execute = 'fail';
			if (mysqli_connect_errno ()) {
				$this->responce = mysqli_connect_errno ();
				echo json_encode ( array ("success" => false, "message" => 'Fail To Connect Database : ' . $this->responce ) );
				exit ();
			}
		} else {
			$resources = mysqli_select_db ( $this->link, $this->databaseName );
			if (! $resources) {
				$this->responce = mysqli_error ( $this->link ) . "Error Code" . mysqli_errno ( $this->link );
				echo json_encode ( array ("success" => false, "message" => $this->responce ) );
				exit ();
			}
		}
	}
	/**
	 * Turns on or off auto-commit mode on queries for the database connection.

	 To determine the current state of autocommit use the SQL command SELECT @@autocommit.
	 */
	public function start() {
		mysqli_autocommit ( $this->link, FALSE );
	}
	/**
	 * query database
	 * @param string $sql
	 * @param string $type
	 * to indentify the query is for view or total record.Available type 1. result type 2 total record
	 * @return number|Ambigous <NULL, resource>|unknown
	 */
	private function query($sql) {
		$this->sql = NULL;
		$this->type = NULL;
		$this->result = NULL;
		$this->countRecord = NULL;
		$this->sql = $sql;
		$error = 0;
		$this->result = mysqli_query ( $this->link, $this->sql );
		if (! $this->result) {
			$this->execute = 'fail';
			$this->responce = "Sql Stament Error" . $this->sql . " \n\r" . mysqli_error ( $this->link ) . " <br> Error Code :x " . mysqli_errno ( $this->link );
			$error = 1;
		}
		if ($error == 1) {

			$sql_log = "
			INSERT	INTO	`".$this->getLogDatabase()."`.`log`
					(
							`leafId`,
							`operation`,
							`sql`,
							`date`,
							`staffId`,
							`logError`
					)
			values
					(
							'" . $this->leafId . "',
							'" . trim ( addslashes ( $this->operation ) ) . "',
							'" . trim ( addslashes ( $this->sql ) ) . "',
							'" . date ( "Y-m-d H:i:s" ) . "',
							'" . $this->staffId . "',
							'" . trim ( $this->realEscapeString ( $sql ) ) . "'
					)";
			$result_row = mysqli_query ( $this->link, $sql_log );
			if (! $result_row) {
				$this->responce = $sql_log . "<br>" . mysqli_error ( $this->link ) . "<br> Error Code :y " . mysqli_errno ( $this->link );
			}
		}

		//	$this->rollback();
		return 0;
	}
	/**
	 * for checking sql statement either it works or not.If no log table error
	 * @param string $operation
	 * @return number
	 */
	private function module($operation) {
		// for more secure option must SET at mysql access grant level
		// if 1 access granted which mean 1 record if null no mean no access to the db level

		$result_row = NULL;
		$this->operation = NULL;
		$sql = "
		SELECT 	*
		FROM 	`leafAccess`
		WHERE  	`leafAccess`.`leafId`			=	'" . $this->leafId . "'
		AND   	`leafAccess`.`" . $operation . "`	=	'1'
		AND   	`leafAccess`.`staffId`		=	'" . $this->staffId . "'";
		$result = mysqli_query ( $this->link, $sql );
		if (! $result) {
			$this->execute = 'FALSE';
			$this->responce = $sql . mysqli_error ( $this->link );
			$result_row = 0;
		} else {
			$result_row = mysqli_num_rows ( $result );
		}
		if ($result_row == 1) {
			$access = 'Granted';
		} elseif ($result_row == 0) {
			$access = 'Denied';
		}

		if ($result_row == 0 || $this->log == 1) {
			$logError = $this->responce;
			$sql_log = "
			INSERT INTO `".$this->getLogDatabase()."`.`log`
					(
						`leafId`,		
						`operation`,
						`sql`,			
						`date`,
						`staffId`,		
						`access`,
						`logError`
					)
			values
					(
						'" . $this->leafId . "',								'" . $operation . "',
						'" . trim ( $this->realEscapeString ( $this->sql ) ) . "',		'" . date ( "Y-m-d H:i:s" ) . "',
						'" . $_SESSION ['staffId'] . "',						'" . $access . "',
						'" . $logError . "'
					)";
			$test1 = mysqli_query ( $this->link, $sql_log );
			if (! $test1) {
				$this->execute = 'fail';
				$this->responce = $sql_log . "[" . mysqli_error ( $this->link ) . "]";
			}
		}

		$result_row=1;
		return ($result_row);
	}
	/**
	 * this is for certain page which don't required to check access page
	 * @param string $sql
	 * @return resource
	 */
	public function queryPage($sql) {
		if (strlen ( $sql ) > 0) {
			$this->sql = $sql;
			return ($this->query ( $this->sql ));
		} else {
			$this->execute = 'fail';
			$this->responce = "Where's the query forgot Yax! ..[" . $sql . "]";
		}
	}
	/**
	 * for delete record
	 * @param string $sql
	 * @return sql statement
	 * @depreciated
	 */
	public function delete($sql) {
	}
	/**
	 * for insert record
	 * @param string $sql
	 * @return sql statement
	 */
	public function create($sql) {
		$this->sql	= NULL;
		$this->sql 	= $sql;
		$text 		= NULL;
		$fieldValue = array ();
		if (strlen ( $sql ) > 0) {
			if ($this->module ( 'leafAccessCreateValue' ) == 1) {
				$this->query ( $this->sql );
				if($this->audit ==1 ){
					$this->insertId = $this->lastInsertId();
				}
				if ($this->audit == 1) {

					$logAdvanceType = 'C';
					$sqlColumn = "SHOW COLUMNS FROM `" . $this->tableName . "`";
					$resultColumn = mysqli_query ( $this->link, $sqlColumn );
					if (! $resultColumn) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlColumn."]";
					} else {
						while ( ($rowColumn = mysqli_fetch_array ( $resultColumn )) == TRUE ) {
							$fieldValue [] = $rowColumn ['Field'];
						}
					}
					$sqlPrevious = "
					SELECT 	*
					FROM 	`" . $this->tableName . "`
					WHERE 	`" . $this->primaryKeyName . "` = '" . $this->lastInsertId () . "'";
					$resultPrevious = mysqli_query ( $this->link, $sqlPrevious );
					if (! $resultPrevious) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlPrevious."]";
					} else {
						while ( ($rowPrevious = mysqli_fetch_array ( $resultPrevious )) == TRUE ) {
							foreach ( $fieldValue as $field ) {
								$text .= "'" . $field . "':'" . $rowPrevious [$field] . "',";
								$previous [$field] = $rowPrevious [$field];
							}
						}
					}
					$text = $this->removeComa ( $text );
					$text = "{" . $text . "}";
					$sqlLogAdvance = "
					INSERT INTO	`".$this->getLogDatabase()."`.`logAdvance`
							(
								`logAdvanceText`,
								`logAdvanceType`,
								`refTableName`,
								`leafId`,
								`executeBy`,
								`executeTime`
							)
					VALUES
							(
								'" . $this->realEscapeString ( $text ) . "',
								'" . $logAdvanceType . "',
								'" . $this->tableName . "',
								'" . $this->leafId . "',
								'" . $this->staffId . "',
								'" . date ( "Y-m-d H:i:s" ) . "'
							)";
					$resultLogAdvance = mysqli_query ( $this->link, $sqlLogAdvance );
					if (! $resultLogAdvance) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlLogAdvance."]";
					}
				}
			} else {
				$this->execute = 'fail';
				$this->responce = "No access ";
			}
		} else {
			$this->execute = 'fail';
			$this->responce = "Where's the query forgot Ya!";
		}
	}
	/**
	 * for update record
	 * @param string $sql
	 * @version 0.1
	 * original just filter by tablename
	 * @version 0.2 filter by program id
	 * @version 0.3 filter by program id and added advance log to diffirenciate old value and new value + affected rows to refence how much record been updated
	 * @return n
	 * umber $record_affected
	 * To return how much record have been deleted
	 */
	public function update($sql) {
		$this->sql 			=	NULL;
		$this->sql 			=	$sql;
		$text 	   			= 	NULL;
		$textComparision 	= 	NULL;
		$fieldValue			= 	array ();
		if (strlen ( $sql ) > 0) {
			if ($this->module ( 'leafAccessUpdateValue' ) == 1) {
				if ($this->audit == 1) {
					$logAdvanceType = 'U';
					$sqlColumn = "SHOW COLUMNS FROM `" . $this->tableName . "`";
					$resultColumn = mysqli_query ( $this->link, $sqlColumn );
					if (! $resultColumn) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlColumn."]";
					} else  {
						while ( ($rowColumn = mysqli_fetch_array ( $resultColumn )) == TRUE ) {
							$fieldValue [] = $rowColumn ['Field'];
						}
					}
					$sqlPrevious = "
					SELECT 	*
					FROM 	`" . $this->tableName . "`
					WHERE 	`" . $this->primaryKeyName . "` = '" . $this->primaryKeyValue . "'";
					$resultPrevious = mysqli_query ( $this->link, $sqlPrevious );
					if (! $resultPrevious) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlPrevious."]";

					} else {
						while ( ($rowPrevious = mysqli_fetch_array ( $resultPrevious )) == TRUE ) {
							foreach ( $fieldValue as $field ) {
								$text .= "'" . $field . "':'" . $rowPrevious [$field] . "',";
								$previous [$field] = $rowPrevious [$field];
							}
						}
					}
					$text = $this->removeComa ( $text );
					$text = "{" . $text . "}";
					$sqlLogAdvance = "
					INSERT INTO	`".$this->getLogDatabase()."`.`logAdvance`
							(
								`logAdvanceText`,
								`logAdvanceType`,
								`refTableName`,
								`leafId`
							)
					VALUES
							(
								'" . $this->realEscapeString ( $text ) . "',
								'" . $logAdvanceType . "',
								'" . $this->tableName . "',
								'" . $this->leafId . "'
					)";
					$resultLogAdvance = mysqli_query ( $this->link, $sqlLogAdvance );
					if ($resultLogAdvance) {
						$logAdvanceId = mysqli_insert_id ( $this->link );
					} else {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlLogAdvance."]";
					}
				}
				$this->query ( $this->sql );
				$recordAffected = $this->affectedRows ();
				if ($this->audit == 1) {
					$sqlCurrent = "
					SELECT 	*
					FROM 	`" . $this->tableName . "`
					WHERE 	`" . $this->primaryKeyName . "`='" . $this->primaryKeyValue . "'";
					$resultCurrent = mysqli_query ( $this->link, $sqlCurrent );
					if (!$resultCurrent) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sqlCurrent."]";
					} else {
						while ( ($rowCurrent = mysqli_fetch_array ( $resultCurrent )) == TRUE ) {
							$textComparision .= $this->compare ( $fieldValue, $rowCurrent, $previous );
						}
					}
					$textComparision = substr ( $textComparision, 0, - 1 );
					$textComparision = "{ \"tablename\":'" . $this->tableName . "',\"leafId\":'" . $this->primaryKeyValue . "'," . $textComparision . "}";
					$sql = "
					UPDATE	`".$this->getLogDatabase()."`.`logAdvance`
					SET 	`logAdvanceComparision`	=	'" . $this->realEscapeString ( $textComparision ) . "',
							`executeBy`					=   '" . $this->staffId . "',
							`executeTime`					=	'" . date ( "Y-m-d H:i:s" ) . "'
					WHERE 	`logAdvanceId`			=	'" . $logAdvanceId . "'";

					$result = mysqli_query ( $this->link, $sql );
					if (! $result) {
						$this->execute = 'fail';
						$this->responce = "Error Message : [ ".mysqli_error ( $this->link ) . "]. Error Code : [" . mysqli_errno ( $this->link )." ]. Error Sql Statement : [".$sql."]";
					}
				}
				return $recordAffected;
			} else {
				$this->execute = 'fail';
				$this->responce = 'access denied lol';
			}

		} else {
			$this->execute = 'fail';
			$this->responce = "Where's the query forgot Ya!";
		}
	}
	/**
	 * for view record
	 * @param string $sql
	 * @return sql statement
	 */
	public function read($sql) {
		/**
		 * initilize dummy value
		 * @var string sql
		 */
		$this->sql = NULL;
		/**
		 * redefine variable
		 * @var string sql
		 */
		$this->sql = $sql;
		/**
		 * initilize dummy value for database column access value.
		 * @var string type
		 */
		$type = NULL;
		/*
		 *  Test string of sql statement.If forgot or not
		 */
		if (strlen ( $sql ) > 0) {
			if ($this->module ( 'leafAccessReadValue' ) == 1) {
				return ($this->query ( $this->sql ));
			} else {
				$this->execute = 'fail';
				$this->responce = " Access Denied View ";
			}
		} else {
			$this->execute = 'fail';
			$this->responce = "Where's the query forgot Ya!";
		}
	}
	public function file($sql) {
		$this->sql = NULL;
		$this->sql = $sql;
		/*
		 *  check if the programmer put query on sql or not
		 */
		if (strlen ( $this->sql ) > 0) {
			$result = mysqli_query ( $this->link, $this->sql );
			if (! $result) {
				$this->execute = 'fail';
				$this->responce = "Sql Stament Error" . $this->sql . " \n\r" . mysqli_error ( $this->link ) . " <br> Error Code :x " . mysqli_errno ( $this->link);
					
			} else {
				return $result;
			}
		} else {
			$this->execute = 'fail';
			$this->responce = "Where's the query forgot Ya!";
		}
	}
	/**
	 * Fast Query Without Log and Return like normal resources query
	 * @param string $sql
	 * @return resource
	 */
	public function fast($sql) {
		$this->sql = NULL;
		$this->sql = $sql;
		/*
		 *  check if the programmer put query on sql or not
		 */
		if (strlen ( $this->sql ) > 0) {
			$result = mysqli_query ( $this->link, $this->sql );
			if (! $result) {
				$this->execute = 'fail';
				$this->responce = "Sql Stament Error" . $this->sql . " \n\r" . mysqli_error ($this->link  ) . " <br> Error Code :x " . mysqli_errno ($this->link );

			} else {
				return $result;
			}
		} else {
			$this->execute = 'fail';
			$this->responce = "Where's the query forgot Ya!";
		}
	}
	/**
	 * Retrieves the number of rows from a result set. This command is only valid for statements like SELECT or SHOW that return an actual result set.
	 * @params $result  result from the query
	 * @params $sql  Previous Sql  Statement.Only valid for oracle database
	 * @return number`
	 * @version 0.1 add result for query doesn't require log future
	 */
	public function numberRows($result = null, $sql = null) {
		if ($result) {
			if (mysqli_num_rows ( $result )) {
				$this->countRecord = mysqli_num_rows ( $result );
			} else {
				$this->countRecord = 0;
			}
			return ($this->countRecord);
		} else if ($this->result) {
			if (mysqli_num_rows ( $this->result )) {
				$this->countRecord = mysqli_num_rows ( $this->result );
			} else {
				$this->countRecord = 0;
			}
			return ($this->countRecord);
		} else {
			$this->execute='fail';
			$this->responce= "Maybe you should check out previous sql statement".$this->sql;
		}

	}
	/**
	 * Retrieves the ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).
	 * @return number
	 */
	public function lastInsertId() {
		// must include this before q->commit; after commit will no output
		if(!($this->insertId)){
			$this->insertId = mysqli_insert_id ( $this->link );
		}
		return $this->insertId;
	}
	/**
	 * Get the number of affected rows by the last INSERT, UPDATE, REPLACE or DELETE query associated with link_identifier.
	 * By default  if not changes the affected rows are null but in this system effected also because of update time and create time.Consider not harmfull bug.
	 */
	public function affectedRows() {
		return mysqli_affected_rows ( $this->link );

		// no information from sql server
	}
	/**
	 * Commits the current transaction for the database connection.
	 */
	public function commit() {
		mysqli_commit ( $this->link );
	}
	/**
	 * Rollbacks the current transaction for the database.
	 */
	private function rollback() {
		mysqli_rollback ( $this->link );
		$this->execute = 'fail';
	}
	/**
	 * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead. mysql_fetch_assoc() is equivalent to calling mysql_fetch_array() with MYSQL_ASSOC for the optional second parameter. It only returns an associative array
	 * @return array
	 * version 0.1 added result future
	 */
	public function fetchArray($result = null) {
		// overide first
		if ($result) {
			return mysqli_fetch_array ( $result );
		}
		if ($this->result) {
			return @mysqli_fetch_array ( $this->result );
		}

	}
	/**
	 *
	 * this only solve problem if  looping /inserting data.result error
	 * @version 0.1 using  fetch_array
	 * @version 0.2 using fetch_assoc  for faster json
	 * @version 0.3 added result future .No Sql Logging
	 */
	public function activeRecord($result = null) {
		$d = array ();
		if ($result) {
			while ( ($row = mysqli_fetch_assoc ( $result )) == TRUE ) {
				$d [] = $row;
			}
		} else {
			while ( ($row = mysqli_fetch_assoc ( $this->result )) == TRUE ) {
				$d [] = $row;
			}
		}
		return $d;
	}
	/**
	 * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead. mysql_fetch_assoc() is equivalent to calling mysql_fetch_array() with MYSQL_ASSOC for the optional second parameter. It only returns an associative array
	 * @version 0.1 added result future.No Sql Logging
	 * @return array
	 */
	public function fetchAssoc($result = null) {
		// overide first
		if ($result) {
			return mysqli_fetch_assoc ( $result );
		}
		if ($this->result && is_null ( $result )) {
			return mysqli_fetch_assoc ( $this->result );
		}
		
	}
	/**
	 * Frees the memory associated with the result.
	 * @version 0.1 added result future.No Sql Logging
	 */
	public function freeResult($result = null) {
		if ($this->result) {
			mysqli_free_result ( $this->result );
		}
		if ($result) {
			mysqli_free_result ( $result );
		}
	}
	/**
	 * Closes a previously opened database connection
	 */
	public function close($result = null) {
		$result = mysqli_close ( $this->link );
		//reSETing null too free up resouces
		$result = null;
		$this->link = null;
	}
	/**
	 * To compare value from old value and new value
	 * @param string field vale come from column name
	 * @param string curr_value come from mysql loop
	 * @param string prev_value come from first value before edit.
	 * @return string
	 */
	private function compare($fieldValue, $curr_value, $prev_value) {
		$textComparision = null;
		foreach ( $fieldValue as $field ) {
			switch ($curr_value [$field]) {
				case is_float ( $curr_value [$field] ) :
					// $type='float';
					$type = 'double';
					$type = 'integer';
					$diff = $curr_value [$field] - $prev_value [$field];
					break;
				case is_numeric ( $curr_value [$field] ) :
					$type = 'integer';
					$diff = $curr_value [$field] - $prev_value [$field];
					break;
				case $this->isDatetime ( $curr_value [$field] ) :
					$type = 'datetime';
					$DownTime = strtotime ( $curr_value [$field] ) - strtotime ( $prev_value [$field] );
					$days = floor ( $DownTime / 86400 ); //    60*60*24 is one day
					$SecondsRemaining = $DownTime % 86400;
					$hours = floor ( $SecondsRemaining / 3600 ); // 60*60 is one hour
					$SecondsRemaining = $SecondsRemaining % 3600;
					$minutes = floor ( $SecondsRemaining / 60 ); // minutes
					$seconds = $SecondsRemaining % 60;
					if ($days > 0) {
						$days = $days . ", ";
					} else {
						$days = NULL;
					}
					$diff = $days . $hours . ":" . $minutes . ":" . $seconds;
					break;
				case is_string ( $curr_value [$field] ) :
					$type = 'string';
					$diff = "No Checking Please";
					break;
				case is_array ( $curr_value [$field] ) :
					$type = 'array';
					$diff = "No Checking Please";
					break;
				case is_null ( $curr_value [$field] ) :
					$type = 'NULL';
					$diff = "Record have been empty";
					break;
				case is_bool ( $curr_value [$field] ) :
					$type = 'boolean';
					$diff = "Cannot Compare bolean record";
					break;
				case is_object ( $curr_value [$field] ) :
					$type = 'object';
					$diff = "Something wrong here why object";
					break;
				case is_resource ( $curr_value [$field] ) :
					$type = 'resource';
					$diff = "Something wrong here why object";
					break;
				default :
					$type = 'unknown type';
					$diff = "System Headache Cannot Figure out  :(";
					break;
			}
			// json format ?
			$textComparision .= "'" . $field . "':[{ \"prev\":'" . $prev_value [$field] . "'},
														{ \"curr\":'" . $curr_value [$field] . "'},
														{ \"type\":'" . $type . "'},
														{ \"diff\":'" . $diff . "'}],";
		}
		return $textComparision;
	}
	public function realEscapeString($data) {
		return mysqli_real_escape_string ( $this->link, $data );
	}
	/**
	 * to send filter result.Quick Search mode
	 * @params array $tableArray
	 * @params array $filterArray
	 * @return string filter
	 */
	public function quickSearch($tableArray, $filterArray) {
		// initilize dummy value
		$i = 0;
		$key=0;
		$strSearch = null;
		$strSearch = "AND ( ";
		foreach ( $tableArray as $tableSearch ) {
			$key=0;
			$i=0;
			$sql = "DESCRIBE	`".$this->getRequestDatabase()."`.`" . $tableSearch . "`";
			$result = mysqli_query ( $this->link, $sql );
			if($result){
				if (@mysqli_num_rows ( $result ) > 0) {
					while ( ($row = mysqli_fetch_array ( $result )) == TRUE ) {
						$strField = "`" . $tableSearch . "`.`" . $row ['Field'] . "`";
						$key = array_search ( $strField, $filterArray, TRUE );
						if (strlen ( $key ) == 0) {
							$strSearch .= " OR  ";
							$i ++;
							$d++;
							$strSearch .= $strField . " like '%" . $this->fieldQuery . "%'";
							if($i==1 && $d==1){
								$strSearch = str_replace("OR","",$strSearch);
							}
						}


					}
				}
			} else {
				$this->execute = 'fail';
				$this->responce = "Sql Stament Error" . $this->sql . " \n\r" . mysqli_error ( $this->link ) . " <br> Error Code :x " . mysqli_errno ( $this->link);
					
			}
		}
		$strSearch .= ")";

		return $strSearch;
	}
	/**
	 * to send filter result.
	 * @return string filter
	 */
	public function searching() {
		$filter = $this->gridQuery;
		if (is_array ( $filter )) {
			for($i = 0; $i < count ( $filter ); $i ++) {
				switch ($filter [$i] ['data'] ['type']) {
					case 'string' :
						$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` LIKE '%" . $this->realEscapeString ( $filter [$i] ['data'] ['value'] ) . "%'";
						break;
					case 'list' :
						$split = explode ( ",", $filter [$i] ['data'] ['value'] );
						foreach ( $split as $split_a ) {
							$str .= "'" . $split_a . "',";
						}
						$str = $this->removeComa ( $str );
						if (count ( $split ) > 0 && strlen ( $filter [$i] ['data'] ['value'] ) > 0) {
							$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "`  IN ($str)";
						}
						break;
					case 'boolean' :
						$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` = " . $this->realEscapeString ( $filter [$i] ['data'] ['value'] );
						break;
					case 'numeric' :
						switch ($filter [$i] ['data'] ['comparison']) {
							case 'ne' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` != " . $this->realEscapeString ( $filter [$i] ['data'] ['value'] );
								break;
							case 'eq' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` = " . $this->realEscapeString ( $filter [$i] ['data'] ['value'] );
								break;
							case 'lt' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` < " . $this->realEscapeString ( $filter [$i] ['data'] ['value'] );
								break;
							case 'gt' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` > " . $this->realEscapeString ( $filter [$i] ['data'] ['value'] );
								break;
						}
						break;
					case 'date' :
						switch ($filter [$i] ['data'] ['comparison']) {
							case 'ne' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` != '" . date ( 'Y-m-d', strtotime ( $filter [$i] ['data'] ['value'] ) ) . "'";
								break;
							case 'eq' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` = '" . date ( 'Y-m-d', strtotime ( $filter [$i] ['data'] ['value'] ) ) . "'";
								break;
							case 'lt' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` < '" . date ( 'Y-m-d', strtotime ( $filter [$i] ['data'] ['value'] ) ) . "'";
								break;
							case 'gt' :
								$qs .= " AND `" . $filter [$i] ['database'] . "`.`" . $filter [$i] ['table'] . "`.`" . $filter [$i] ['column'] . "` > '" . date ( 'Y-m-d', strtotime ( $filter [$i] ['data'] ['value'] ) ) . "'";
								break;
						}
						break;
				}
			}

			//$where .= $qs;
		}

		if (isset ( $qs )) {
			return $qs;
		}
	}

	function dateFilter($tableName,$columnName,$startDate,$endDate,$dateFilterTypeQuery) {
		$sql="";
		$this->setTableName($tableName);
		$this->setColumnName($columnName);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);

		$this->setDateFilterTypeQuery($dateFilterTypeQuery);

		$dayStart=substr($this->getStartDate(),8,2);
		$monthStart=substr($this->getStartDate(),5,2);
		$yearStart=substr($this->getStartDate(),0,4);
			
		if($this->getEndDate()){
			$dayEnd=substr($this->getEndDate(),8,2);
			$monthEnd=substr($this->getEndDate(),5,2);
			$yearEnd=substr($this->getEndDate(),0,4);
		}
		if($this->getDateFilterTypeQuery()=='day') {
				
			return(" and `".$this->getTableName()."`.`".$this->getColumnName()."` like '%".$this->getStartDate()."%'");
		}
		elseif($this->getDateFilterTypeQuery()=='month') {

			return(" and (month(`".$this->getTableName()."`.`".$this->getColumnName()."`)='".$monthStart."')  and (year(`".$this->getTableName()."`.`".$this->getColumnName()."`)='".$yearStart."')");

		}
		elseif($this->getDateFilterTypeQuery()=='year') {

			return(" and (year(`".$this->getTableName()."`.`".$this->getColumnName()."`)='".$yearStart."')");

		}
		elseif($this->getDateFilterTypeQuery()=='between' || $this->getDateFilterTypeQuery()=='week') {
			//echo ($sql." and `".$this->getTableName()."`.`".$this->getColumnName()."` between '".$this->getStartDate()."' and '".$this->getEndDate()."' ");

			return($sql." and (`".$this->getTableName()."`.`".$this->getColumnName()."` between '".$this->getStartDate()."' and '".$this->getEndDate()."')");

		}
	}
	/**
	 * Checking date if  TRUE or false
	 * @param date $dateTime
	 * @return boolean
	 */
	public function isDatetime($dateTime) {
		if (preg_match ( "/^({4})-({2})-({2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches )) {
			if (checkdate ( $matches [2], $matches [3], $matches [1] )) {
				return TRUE;
			}
		}
		return false;
	}
	/**
	 * // this is for extjs .remove coma trail
	 * @param unknown_type $str
	 * @return string
	 */
	public function removeComa($str) {
		return substr ( $str, 0, - 1 );
	}
	/**
	 * @return the $requestDatabase
	 */
	public function getRequestDatabase() {
		return $this->requestDatabase;
	}

	/**
	 * @param number $defaultLanguageId
	 */
	public function setRequestDatabase($requestDatabase) {
		$this->requestDatabase = $requestDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getCoreDatabase()
	{
		return $this->coreDatabase;
	}

	/**
	 *
	 * @param $coreDatabase
	 */
	public function setCoreDatabase($coreDatabase)
	{
		$this->coreDatabase = $coreDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getFinancialDatabase()
	{
		return $this->financialDatabase;
	}

	/**
	 *
	 * @param $financialDatabase
	 */
	public function setFinancialDatabase($financialDatabase)
	{
		$this->financialDatabase = $financialDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getFixAssetDatabase()
	{
		return $this->fixAssetDatabase;
	}

	/**
	 *
	 * @param $fixAssetDatabase
	 */
	public function setFixAssetDatabase($fixAssetDatabase)
	{
		$this->fixAssetDatabase = $fixAssetDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getPayrollDatabase()
	{
		return $this->payrollDatabase;
	}

	/**
	 *
	 * @param $payrollDatabase
	 */
	public function setPayrollDatabase($payrollDatabase)
	{
		$this->payrollDatabase = $payrollDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getHumanResourcesDatabase()
	{
		return $this->humanResourcesDatabase;
	}

	/**
	 *
	 * @param $humanResourcesDatabase
	 */
	public function setHumanResourcesDatabase($humanResourcesDatabase)
	{
		$this->humanResourcesDatabase = $humanResourcesDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getCommonDatabase()
	{
		return $this->commonDatabase;
	}

	/**
	 *
	 * @param $commonDatabase
	 */
	public function setCommonDatabase($commonDatabase)
	{
		$this->commonDatabase = $commonDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getManagementDatabase()
	{
		return $this->managementDatabase;
	}

	/**
	 *
	 * @param $managementDatabase
	 */
	public function setManagementDatabase($managementDatabase)
	{
		$this->managementDatabase = $managementDatabase;
	}

	/**
	 *
	 * @return
	 */
	public function getTableName()
	{
		return $this->tableName;
	}

	/**
	 *
	 * @param $tableName
	 */
	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
	}

	/**
	 *
	 * @return
	 */
	public function getPrimaryKeyName()
	{
		return $this->primaryKeyName;
	}

	/**
	 *
	 * @param $primaryKeyName
	 */
	public function setPrimaryKeyName($primaryKeyName)
	{
		$this->primaryKeyName = $primaryKeyName;
	}

	/**
	 *
	 * @return
	 */
	public function getPrimaryKeyValue()
	{
		return $this->primaryKeyValue;
	}

	/**
	 *
	 * @param $primaryKeyValue
	 */
	public function setPrimaryKeyValue($primaryKeyValue)
	{
		$this->primaryKeyValue = $primaryKeyValue;
	}

	/**
	 *
	 * @return
	 */
	public function getColumnName()
	{
		return $this->columnName;
	}

	/**
	 *
	 * @param $columnName
	 */
	public function setColumnName($columnName)
	{
		$this->columnName = $columnName;
	}

	/**
	 *
	 * @return
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}

	/**
	 *
	 * @param $startDate
	 */
	public function setStartDate($startDate)
	{
		$this->startDate = $startDate;
	}

	/**
	 *
	 * @return
	 */
	public function getEndDate()
	{
		return $this->endDate;
	}

	/**
	 *
	 * @param $endDate
	 */
	public function setEndDate($endDate)
	{
		$this->endDate = $endDate;
	}

	/**
	 *
	 * @return
	 */
	public function getDateFilterTypeQuery()
	{
		return $this->dateFilterTypeQuery;
	}

	/**
	 *
	 * @param $dateFilterTypeQuery
	 */
	public function setDateFilterTypeQuery($dateFilterTypeQuery)
	{
		$this->dateFilterTypeQuery = $dateFilterTypeQuery;
	}

	public function getLogDatabase()
	{
	    return $this->logDatabase;
	}

	public function setLogDatabase($logDatabase)
	{
	    $this->logDatabase = $logDatabase;
	}
}
?>
