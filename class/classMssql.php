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
class Vendor
{
    // private property
    private $connection;
    private $username;
    private $databaseName;
    private $operation;
    private $port;
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
     * to inform user if error
     * @var string
     */
    public $responce;
    /**
     * to inform user if error
     * @var string $execute
     */
    public $execute;
    /**
     * to filter sql statement
     * @var string
     */
    public $filter; //  bugs must filter the  special character with sql escape
    public $staffId;
    public $insertId;
    public function __construct ()
    {}
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
    public function connect ($connection, $username, $database, $password)
    {
        $this->connection = $connection;
        $this->username = $username;
        $this->databaseName = $database;
        $this->password = $password;
        $this->link = sqlsrv_connect($this->connection, 
        array("UID" => $this->username, "PWD" => $this->password, 
        "Database" => $this->databaseName, "CharacterSet" => "UTF-8"));
        if (! $this->link) {
            $this->execute = 'fail';
            $errorArray = array();
            $errorArray = sqlsrv_errors();
            $error .= " CE Sql State : " . $errorArray[0]['SQLSTATE'];
            $error .= " Code : " . $errorArray[0]['code'];
            $error .= " Message : " . $errorArray[0]['message'];
            $this->responce = $error;
            echo json_encode(
            array("success" => false, 
            "message" => 'Fail To Connect Database : ' . $this->responce));
            exit();
        }
    }
    /**
     * Turns on or off auto-commit mode on queries for the database connection.
	  
	 To determine the current state of autocommit use the SQL command SELECT @@autocommit.
     */
    public function start ()
    {
        if (sqlsrv_begin_transaction($this->link) === false) {
            $errorArray = array();
            $errorArray = sqlsrv_errors();
            $error .= " TE Sql State : " . $errorArray[0]['SQLSTATE'];
            $error .= " Code : " . $errorArray[0]['code'];
            $error .= " Message : " . $errorArray[0]['message'];
            $this->responce = $error;
            echo json_encode(
            array("success" => false, 
            "message" => 'Fail To Commit Transaction : ' . $this->responce));
            exit();
        }
    }
    /**
     * query database
     * @param string $sql
     * @param string $type
     * to indentify the query is for view or total record.Available type 1. result type 2 total record
     * @return number|Ambigous <NULL, resource>|unknown
     */
    private function query ($sql)
    {
        $this->sql = NULL;
        $this->type = NULL;
        $this->result = NULL;
        $this->countRecord = NULL;
        $this->sql = $sql;
        $error = 0;
        $this->result = sqlsrv_query($this->link, $this->sql);
        if (! $this->result) {
            $this->execute = 'fail';
            $errorArray = array();
            $errorArray = sqlsrv_errors();
            $error .= " TE Sql State : " . $errorArray[0]['SQLSTATE'];
            $error .= " Code : " . $errorArray[0]['code'];
            $error .= " Message : " . $errorArray[0]['message'];
            $error .= " Message : " . $sql;
            $this->responce = $error;
            $error = 1;
        }
        if ($error == 1) {
            $sqlLog = "
					INSERT	INTO	[log]
								(
									[leafId],
									[operation],
									[sql],
									[date],
									[staffId],
									[log_error]
								)
						values
								(
									'" . $this->leafId . "',
									'" . trim(addslashes($this->operation)) . "',
									'" . trim(addslashes($this->sql)) . "',
									'" . date("Y-m-d H:i:s") . "',
									'" . $this->staffId . "',
									'" . $this->realEscapeString($sql) . "'
								)";
            $result_row = sqlsrv_query($this->link, $sql_log);
            if (! $result_row) {
                $errorArray = array();
                $errorArray = sqlsrv_errors();
                $error .= " TE Sql State : " . $errorArray[0]['SQLSTATE'];
                $error .= " Code : " . $errorArray[0]['code'];
                $error .= " Message : " . $errorArray[0]['message'];
                $this->responce = $error;
            }
            //	$this->rollback();
            return 0;
        }
    }
    /**
     * for checking sql statement either it works or not.If no log table error
     * @param string $operation
     * @return number
     */
    private function module ($operation)
    {
        // for more secure option must SET at mysql access grant level
        // if 1 access granted which mean 1 record if null no mean no access to the db level
        $result_row = NULL;
        $this->operation = NULL;
        $sql = "
		SELECT 	*
		FROM 	[leafAccess]
		WHERE  [leafAccess].[leafId]				=	'" . $this->leafId . "'
		AND   	[leafAccess].[" . $operation . "]	=	'1'
		AND   	[leafAccess].[staffId]				=	'" . $this->staffId .
         "'";
        $result = sqlsrv_query($this->link, $sql, array(), 
        array("Scrollable" => SQLSRV_CURSOR_KEYSET));
        if (! $result) {
            $this->execute = 'false';
            $errorArray = array();
            $errorArray = sqlsrv_errors();
            $error .= " MS Sql State : " . $errorArray[0]['SQLSTATE'];
            $error .= " Code : " . $errorArray[0]['code'];
            $error .= " Message : " . $errorArray[0]['message'];
            $this->responce = $error;
            $resultRow = 0;
        } else {
            $rowCount = sqlsrv_num_rows($result);
            if ($rowCount === false) {
                $this->responce = $sql . sqlsrv_errors();
            } else 
                if ($rowCount >= 0) {
                    $resultRow = $rowCount;
                }
        }
        if ($resultRow == 1) {
            $access = 'Granted';
        } elseif ($resultRow == 0) {
            $access = 'Denied';
        }
        //echo "access".$access;
        /*
		 *  Only disable and Error Sql Statement will be log
		 */
        if ($result_row == 0 || $this->log == 1) {
            // only trim out the last operation query.per limit query doesn't require because it's the same sql statement to track
            //	$operation = str_replace("leaf","",$operation);
            //	$operation = str_replace("Access","",$operation);
            //	$operation = str_replace("Value","",$operation);
            $sql_log = "
								INSERT INTO [log] (
											[leafId],
											[operation],
											[sql],
											[date],
											[staffId],
											[access],
											[log_error]
								) values (
											'" . $this->leafId . "',
											'" . $operation . "',
											'" . $this->realEscapeString($this->sql) . "',
											'" . date("Y-m-d H:i:s") . "',
											'" . $_SESSION['staffId'] . "',
											'" . $access . "',
											'" . $this->realEscapeString($sql) . "')";
            sqlsrv_query($this->link, $sql_log);
            $errorArray = array();
            $errorArray = sqlsrv_errors();
            $error .= " IL Sql State : " . $errorArray[0]['SQLSTATE'];
            $error .= " Code : " . $errorArray[0]['code'];
            $error .= " Message : " . $errorArray[0]['message'];
            $this->responce = $error;
            return ($resultRow);
        }
    }
    /**
     * this is for certain page which don't required to check access page
     * @param string $sql
     * @return resource
     */
    public function queryPage ($sql)
    {
        if (strlen($sql) > 0) {
            $this->sql = $sql;
            return ($this->query($this->sql));
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
    public function delete ($sql)
    {}
    /**
     * for insert record
     * @param string $sql
     * @return sql statement
     */
    public function create ($sql)
    {
        $this->sql = NULL;
        $this->sql = $sql;
        if (strlen($sql) > 0) {
            if ($this->module('leafAccessCreateValue') == 1) {
                return ($this->query($this->sql));
            } else {
                echo "no access insert ";
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
     * @return number $record_affected
     * To return how much record have been deleted
     */
    public function update ($sql)
    {
        $this->sql = NULL;
        $this->sql = $sql;
        if (strlen($sql) > 0) {
            if ($this->module('leafAccessUpdateValue') == 1) {
                if ($this->audit == 1) {
                    $logAdvanceType = 'U'; // aka update
                    $sqlColumn = "SHOW COLUMNS FROM `" .
                     $this->tableName . "`";
                    if ($this->vendor == 'normal') {
                        $resultColumn = mysql_query($sqlColumn, $this->link);
                        if (! $resultColumn) {
                            $this->execute = 'fail';
                            $this->responce = "Error selecting table";
                        }
                    } else 
                        if ($this->getVendor() == self::mysql) {
                            $resultColumn = mysqli_query($this->link, 
                            $sqlColumn);
                            if (! $resultColumn) {
                                $this->execute = 'fail';
                                $this->responce = "Error selecting table";
                            }
                        }
                    $fieldValue = array();
                    if ($this->vendor == 'normal') {
                        if (! $resultColumn) {
                            $this->execute = 'fail';
                            $this->responce = mysql_error() . "Error Code" .
                             mysql_errno();
                        } else {
                            while ($rowColumn = mysql_fetch_array($resultColumn)) {
                                // create the field value
                                $fieldValue[] = $rowColumn['Field'];
                            }
                        }
                    } elseif ($this->getVendor() == self::mysql) {
                        if (! $resultColumn) {
                            $this->execute = 'fail';
                            $this->responce = mysqli_error($this->link) .
                             "Error Code" . mysqli_errno($$this->link);
                        } else {
                            //	echo "Jumlah Rekod".mysqli_num_rows($resultColumn);
                            while ($rowColumn = mysqli_fetch_array(
                            $resultColumn)) {
                                // create the field value
                                $fieldValue[] = $rowColumn['Field'];
                            }
                        }
                    }
                    $sqlPrevious = "
					SELECT 	*
					FROM 	[" . $this->tableName . "]
					WHERE 	[" . $this->primaryKeyName . "] = '" . $this->primaryKeyValue .
                     "'";
                    if ($this->vendor == 'normal') {
                        $resultPrevious = mysql_query($sqlPrevious, $this->link);
                        if (! $resultPrevious) {
                            $this->execute = 'fail';
                            $this->responce = mysql_error . " Error Code" .
                             mysql_errno();
                        } else {
                            while ($rowPrevious = mysql_fetch_array(
                            $resultPrevious)) {
                                foreach ($fieldValue as $field) {
                                    $text .= "\"" . $field . "\":\"" .
                                     $rowPrevious[$field] . "\",";
                                    $previous[$field] = $rowPrevious[$field];
                                }
                            }
                        }
                    } else 
                        if ($this->getVendor() == self::mysql) {
                            $resultPrevious = mysqli_query($this->link, 
                            $sqlPrevious);
                            if (! $resultPrevious) {
                                $this->execute = 'fail';
                                $this->responce = mysqli_error($this->link) .
                                 "Error Code" . mysqli_errno($this->link);
                            } else {
                                // successfully
                                //	echo "Jumlah Rekod ".mysqli_num_rows($resultPrevious);
                                while ($rowPrevious = mysqli_fetch_array(
                                $resultPrevious)) {
                                    foreach ($fieldValue as $field) {
                                        $text .= "\"" . $field . "\":\"" .
                                         $rowPrevious[$field] . "\",";
                                        $previous[$field] = $rowPrevious[$field];
                                    }
                                }
                            }
                        }
                    $text = $this->removeComa($text);
                    $text = "{" . $text . "}"; // using json data format ?
                    $sqlLogAdvance = "
					INSERT INTO 	`logAdvance`
					(
					`logAdvanceText`,
					`logAdvanceType`,
					`refId`
					)
					VALUES 		(
					'" . $text . "',
					'" . $logAdvanceType . "',
					'" . $this->leafId . "'
					)";
                    if ($this->vendor == 'normal') {
                        $resultLogAdvance = mysql_query($sqlLogAdvance, 
                        $this->link);
                        if ($resultLogAdvance) {
                            $logAdvanceId = mysql_insert_id(); // take the last id for references
                        } else {
                            $this->execute = 'fail';
                            $this->responce = "Error inserting Query Advance insert";
                        }
                    } else 
                        if ($this->getVendor() == self::mysql) {
                            $resultLogAdvance = mysqli_query($this->link, 
                            $sqlLogAdvance);
                            if ($resultLogAdvance) {
                                // take the last id for references
                                $logAdvanceId = mysqli_insert_id(
                                $this->link); //
                            } else {
                                $this->execute = 'fail';
                                $this->responce = "error inserting query update insert";
                            }
                        }
                }
                $this->query($this->sql);
                $record_affected = $this->affectedRows(); // direct call for can now how much record have been deleted and make error handling
                if ($this->audit == 1) {
                    // select the current update file
                    $sqlCurrent = "
					SELECT 	*
					FROM 	`" . $this->tableName . "`
					WHERE 	`" . $this->primaryKeyName . "`=\"" . $this->primaryKeyValue .
                     "\"";
                    if ($this->vendor == 'normal') {
                        $resultCurrent = mysql_query($sqlCurrent, $this->link);
                        if ($resultCurrent) {
                            while ($rowCurrent = mysql_fetch_array(
                            $resultCurrent)) {
                                $textComparison .= $this->compare($fieldValue, 
                                $rowCurrent, $previous);
                            }
                        } else {
                            $this->execute = 'fail';
                            $this->responce = "Error Query on advance select";
                        }
                    } else 
                        if ($this->getVendor() == self::mysql) {
                            $resultCurrent = mysqli_query($this->link, 
                            $sqlCurrent);
                            if ($resultCurrent) {
                                while ($rowCurrent = mysqli_fetch_array(
                                $resultCurrent)) {
                                    $textComparison .= $this->compare(
                                    $fieldValue, $rowCurrent, $previous);
                                }
                            } else {
                                $this->execute = 'fail';
                                $this->responce = "Error Query on advance select" .
                                 $sqlCurrent;
                            }
                        }
                    $textComparison = substr($textComparison, 0, - 1); // remove last coma
                    $textComparison = "{ \"tablename\":\"" .
                     $this->tableName . "\",\"ref_uniqueId\":\"" .
                     $this->primaryKeyValue . "\"," . $textComparison . "}"; // json format
                    // update back comparision the previous record
                    $sql = "
					UPDATE	`logAdvance`
					SET 	`logAdvanceComparison`=\"" . addslashes($textComparison) . "\"
					WHERE 	`logAdvanceId`=\"" . $logAdvanceId . "\"";
                    if ($this->vendor == 'normal') {
                        $result = mysql_query($sql, $this->link);
                        if (! $result) {
                            $this->execute = 'fail';
                            $this->responce = "Error Query update log advance";
                        }
                    } else 
                        if ($this->getVendor() == self::mysql) {
                            $result = mysqli_query($this->link, $sql);
                            if (! $result) {
                                $this->execute = 'fail';
                                $this->responce = "Error Query update log advance";
                            }
                        }
                }
            } else {
                $this->execute = 'fail';
                $this->responce = 'access denied lol';
            }
            return $record_affected;
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
    public function read ($sql)
    {
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
        if (strlen($sql) > 0) {
            if ($this->module('leafAccessReadValue') == 1) {
                return ($this->query($this->sql));
            } else {
                $this->execute = 'fail';
                $this->responce = " Access Denied View ";
            }
        } else {
            $this->execute = 'fail';
            $this->responce = "Where's the query forgot Ya!";
        }
    }
    public function file ($sql)
    {
        $this->sql = NULL;
        $this->sql = $sql;
        /*
		 *  check if the programmer put query on sql or not
		 */
        if (strlen($sql) > 0) {
            $result = sqlsrv_query($this->link, $this->sql);
            return $result;
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
    public function fast ($sql)
    {
        $this->sql = NULL;
        $this->sql = $sql;
        if (strlen($sql) > 0) {
            return sqlsrv_query($this->link, $this->sql, array(), 
            array("Scrollable" => SQLSRV_CURSOR_KEYSET));
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
    public function numberRows ($result = null, $sql = null)
    {
        $this->countRecord = 0;
        if ($result) {
            $rowCount = sqlsrv_num_rows($result);
            if ($rowCount === false) {
                echo print_r(sqlsrv_errors());
            } else 
                if ($rowCount >= 0) {
                    $this->countRecord = $rowCount;
                }
        } else {
            $result = sqlsrv_query($this->link, $this->sql, array(), 
            array("Scrollable" => SQLSRV_CURSOR_KEYSET));
            if ($result) {
                $rowCount = sqlsrv_num_rows($result);
                if ($rowCount === false) {
                    echo print_r(sqlsrv_errors());
                } else 
                    if ($rowCount >= 0) {
                        $this->countRecord = $rowCount;
                    }
            } else {}
        }
        return ($this->countRecord);
    }
    /**
     * Retrieves the ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).
     * @return number
     */
    public function lastInsertId ()
    {
        // must include this before q->commit; after commit will no output
        $resultId = sqlsrv_query("SELECT LAST_INSERT_ID=@@IDENTITY");
        $rowId = sqlsrv_fetch_array($resultId, SQLSRV_FETCH_ASSOC);
        $this->insert_id = $rowId['LAST_INSERT_ID'];
        //	echo "This come from class ".$this->insert_id;
        return $this->insert_id;
    }
    /**
     * Get the number of affected rows by the last INSERT, UPDATE, REPLACE or DELETE query associated with link_identifier.
     * By default  if not changes the affected rows are null but in this system effected also because of update time and create time.Consider not harmfull bug.
     */
    public function affectedRows ()
    {
        return mysqli_affected_rows($this->link);
         // no information from sql server
    }
    /**
     * Commits the current transaction for the database connection.
     */
    public function commit ()
    {
        sqlsrv_commit($this->link);
    }
    /**
     * Rollbacks the current transaction for the database.
     */
    private function rollback ()
    {
        // in mysql there are no indicator rollback list.rollbak only available in current transaction only
        sqlsrv_rollback($this->link);
        $this->execute = 'fail';
    }
    /**
     * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead. mysql_fetch_assoc() is equivalent to calling mysql_fetch_array() with MYSQL_ASSOC for the optional second parameter. It only returns an associative array
     * @return array
     * version 0.1 added result future
     */
    public function fetchArray ($result = null)
    {
        if ($this->result) {
            return @sqlsrv_fetch_array($this->result, SQLSRV_FETCH_BOTH);
        }
        if ($result) {
            return @sqlsrv_fetch_array($result, SQLSRV_FETCH_BOTH);
        }
    }
    /**
     *
     * this only solve problem if  looping /inserting data.result error
     * @version 0.1 using  fetch_array
     * @version 0.2 using fetch_assoc  for faster json
     * @version 0.3 added result future .No Sql Logging
     */
    public function activeRecord ($result = null)
    {
        $d = array();
        if ($result) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $d[] = $row;
            }
        } else {
            while ($row = sqlsrv_fetch_array($this->result, SQLSRV_FETCH_ASSOC)) {
                $d[] = $row;
            }
        }
        return $d;
    }
    /**
     * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead. mysql_fetch_assoc() is equivalent to calling mysql_fetch_array() with MYSQL_ASSOC for the optional second parameter. It only returns an associative array
     * @version 0.1 added result future.No Sql Logging
     * @return array
     */
    public function fetchAssoc ($result = null)
    {
        // tried consept push to array and sending array back
        if ($this->result && is_null($result)) {
            return sqlsrv_fetch_array($this->result, SQLSRV_FETCH_ASSOC);
        }
        if ($result) {
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        }
    }
    /**
     * Frees the memory associated with the result.
     * @version 0.1 added result future.No Sql Logging
     */
    public function freeResult ($result = null)
    {
        if ($this->result) {
            sqlsrv_free_stmt($this->result);
        }
        if ($result) {
            sqlsrv_free_stmt($result);
        }
    }
    /**
     * Closes a previously opened database connection
     */
    public function close ($result = null)
    {
        $result = sqlsrv_close($this->link);
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
    private function compare ($fieldValue, $curr_value, $prev_value)
    {
        foreach ($fieldValue as $field) {
            switch ($curr_value[$field]) {
                case is_float($curr_value[$field]):
                    // $type='float';
                    $type = 'double';
                    $type = 'integer';
                    $diff = $curr_value[$field] - $prev_value[$field];
                    break;
                case is_numeric($curr_value[$field]):
                    $type = 'integer';
                    $diff = $curr_value[$field] - $prev_value[$field];
                    break;
                case $this->isDatetime($curr_value[$field]):
                    $type = 'datetime';
                    $DownTime = strtotime($curr_value[$field]) -
                     strtotime($prev_value[$field]);
                    $days = floor($DownTime / 86400); //    60*60*24 is one day
                    $SecondsRemaining = $DownTime % 86400;
                    $hours = floor($SecondsRemaining / 3600); // 60*60 is one hour
                    $SecondsRemaining = $SecondsRemaining %
                     3600;
                    $minutes = floor($SecondsRemaining / 60); // minutes
                    $seconds = $SecondsRemaining % 60;
                    if ($days > 0) {
                        $days = $days . ", ";
                    } else {
                        $days = NULL;
                    }
                    $diff = $days . $hours . ":" . $minutes . ":" . $seconds;
                    break;
                case is_string($curr_value[$field]):
                    $type = 'string';
                    $diff = "No Checking Please";
                    break;
                case is_array($curr_value[$field]):
                    $type = 'array';
                    $diff = "No Checking Please";
                    break;
                case is_null($curr_value[$field]):
                    $type = 'NULL';
                    $diff = "Record have been empty";
                    break;
                case is_bool($curr_value[$field]):
                    $type = 'boolean';
                    $diff = "Cannot Compare bolean record";
                    break;
                case is_object($curr_value[$field]):
                    $type = 'object';
                    $diff = "Something wrong here why object";
                    break;
                case is_resource($curr_value[$field]):
                    $type = 'resource';
                    $diff = "Something wrong here why object";
                    break;
                default:
                    $type = 'unknown type';
                    $diff = "System Headache Cannot Figure out  :(";
                    break;
            }
            // json format ?
            $textComparison .= "\"" . $field . "\":[{ \"prev\":\"" .
             $prev_value[$field] . "\"},
														{ \"curr\":\"" . $curr_value[$field] . "\"},
														{ \"type\":\"" . $type . "\"},
														{ \"diff\":\"" . $diff . "\"}],";
        }
        return $textComparison;
    }
    /**
     * Escape string
     * @param string $data
     * @return string
     */
    public function realEscapeString ($data)
    {
        /*
		 /*
		 * @depreciate
		 	
		 $singQuotePattern = "'";
		 $singQuoteReplace = "''";
		 return (stripslashes(eregi_replace($singQuotePattern, $singQuoteReplace, $data)));
		 **/
        if (! isset($data) or empty($data))
            return ' ';
        if (is_numeric($data))
            return $data;
        $non_displayables = array('/%0[0-8bcef]/', // url encoded 00-08, 11, 12, 14, 15
'/%1[0-9a-f]/',  // url encoded 16-31
        '/[\x00-\x08]/', // 00-08
'/\x0b/', // 11
'/\x0c/', // 12
'/[\x0e-\x1f]/');// 14-31

        foreach ($non_displayables as $regex)
            $data = preg_replace($regex, '', $data);
        $data = str_replace("'", "''", $data);
        return $data;
    }
    /**
     * to send filter result.Quick Search mode
     * @params array $tableArray
     * @params array $filterArray
     * @return string filter
     */
    public function quickSearch ($tableArray, $filterArray)
    {
        $i = 0;
        $strSearch = null;
        $strSearch = "AND ( ";
        foreach ($tableArray as $tableSearch) {
            $sql = "
				select *
  				from information_schema.columns
 				where table_name = " . $tableSearch . "
 				order by ordinal_position";
            $this->query_view($sql);
            if ($this->num_rows() > 0) {
                while (($row = $this->fetch_array()) == TRUE) {
                   
                            $strField = "[" . $tableSearch . "].[" .
                             $row['COLUMN_NAME'] . "]";
                        
                    $key = array_search($strField, $filterArray, true);
                    if ($i > 0 && strlen($key) == 0) {
                        $strSearch .= " OR  ";
                    }
                    if (strlen($key) == 0) {
                        $strSearch .= $strField . " like '%" . $this->quickFilter .
                         "%'";
                    }
                    $i ++;
                }
            } else {
                echo "something wrong here";
            }
        }
        $strSearch .= ")";
        return $strSearch;
    }
    /**
     * to send filter result.
     * @return string filter
     */
    public function searching ()
    {
        $filter = $this->filter;
        if (is_array($filter)) {
            for ($i = 0; $i < count($filter); $i ++) {
                switch ($filter[$i]['data']['type']) {
                    case 'string':
                        $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                         $filter[$i]['column'] . "] LIKE '%" .
                         $this->realEscapeString($filter[$i]['data']['value']) .
                         "%'";
                        break;
                    case 'list':
                        $split = explode(",", $filter[$i]['data']['value']);
                        foreach ($split as $split_a) {
                            $str .= "'" . $split_a . "',";
                        }
                        $str = $this->removeComa($str);
                        if (count($split) > 0 &&
                         strlen($filter[$i]['data']['value']) > 0) {
                            $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                             $filter[$i]['column'] . "]  IN ($str)";
                        }
                        break;
                    case 'boolean':
                        $qs .= " AND [" . $filter[$i]['column'] . "] = " .
                         $this->realEscapeString($filter[$i]['data']['value']);
                        break;
                    case 'numeric':
                        switch ($filter[$i]['data']['comparison']) {
                            case 'ne':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] != " . $this->realEscapeString(
                                $filter[$i]['data']['value']);
                                break;
                            case 'eq':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] = " . $this->realEscapeString(
                                $filter[$i]['data']['value']);
                                break;
                            case 'lt':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] < " . $this->realEscapeString(
                                $filter[$i]['data']['value']);
                                break;
                            case 'gt':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] > " . $this->realEscapeString(
                                $filter[$i]['data']['value']);
                                break;
                        }
                        break;
                    case 'date':
                        switch ($filter[$i]['data']['comparison']) {
                            case 'ne':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] != \"" .
                                 date('Y-m-d', 
                                strtotime($filter[$i]['data']['value'])) . "\"";
                                break;
                            case 'eq':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] = \"" .
                                 date('Y-m-d', 
                                strtotime($filter[$i]['data']['value'])) . "\"";
                                break;
                            case 'lt':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] < \"" .
                                 date('Y-m-d', 
                                strtotime($filter[$i]['data']['value'])) . "\"";
                                break;
                            case 'gt':
                                $qs .= " AND [" . $filter[$i]['table'] . "].[" .
                                 $filter[$i]['column'] . "] > \"" .
                                 date('Y-m-d', 
                                strtotime($filter[$i]['data']['value'])) . "\"";
                                break;
                        }
                        break;
                }
            }
             //$where .= $qs;
        }
        if (isset($qs)) {
            return $qs;
        }
    }
    /**
     * Checking date if  true or false
     * @param date $dateTime
     * @return boolean
     */
    public function isDatetime ($dateTime)
    {
        if (preg_match(
        "/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", 
        $dateTime, $matches)) {
            if (checkdate($matches[2], $matches[3], $matches[1])) {
                return true;
            }
        }
        return false;
    }
    /**
     * // this is for extjs .remove coma trail
     * @param unknown_type $str
     * @return string
     */
    public function removeComa ($str)
    {
        return substr($str, 0, - 1);
    }
}
?>
