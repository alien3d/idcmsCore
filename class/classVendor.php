<?php	/**
*  a specific class for connection to mysql.Either mysql or mysqli
* @author hafizan
* @copyright IDCMS
* @version 1.0
* @version 1.1 new support for Microsoft Sql Server. 02/12/2011
* @version 1.2 new support for Oracle 02/15/2011
* @version 1.3 change for provider to vendor instead of mysqldb
*/
class vendor {
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
	public  $sql;
	/**
	 *  link resources
	 * @var result
	 */
	public 	$link;
	/**
	 * result statement
	 * @var result
	 */
	public  $result;
	/**
	 *  tablename for advance loging purpose
	 * @var string
	 */
	public 	$tableName;
	/**
	 *  primary key  for advance loging purpose
	 * @var string
	 */
	public 	$primaryKeyName;
	/**
	 * primary key value for advance loging purpose
	 * @var string
	 */
	public  $primaryKeyValue;
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
	 *   per page record
	 * @var number
	 */

	public  $offset;
	/**
	 *  per page record
	 * @var number
	 */
	public  $limit;
	/**
	 *  ver Mysql,Mysqli,Oracle,Sql Server
	 * @var string
	 */
	public  $vendor;
	/**
	 *  total record
	 * @var number
	 */
	public  $countRecord;
	public  $sorting;
	/**
	 *  program id
	 * @var numeric
	 */
	public 	$leafId;
	/**
	 *  to inform user if error
	 * @var string
	 */
	public 	$result_text;
	/**
	 *  to inform user if error
	 * @var string $execute
	 */
	public  $execute;
	/**
	 *  to filter sql statement
	 * @var string
	 */
	public  $filter; //  bugs must filter the  special character with sql escape
	public  $staffId;
	/**
	 * predefine commit constructor for oracle database extension
	 */
	public $oracleCommit=0;
	private $mysqlOpenTag;
	private $mysqlCloseTag;
	private $sqlServerOpenTag;
	private $sqlServerCloseTag;
	private $oracleOpenTag;
	private $oracleCloseTag;

	private $globalOpenTag;
	private $globalCloseTag;

	public function __construct() {
		$this->mysqlOpenTag="`";
		$this->mysqlCloseTag="`";
		$this->sqlServerOpenTag="[";
		$this->sqlServerCloseTag="]";
		$this->oracleOpenTag="\"";
		$this->oracleCloseTag="\"";
		switch($_SESSION['vendor']){
			case 'normal':
			case 'lite':
				$this->globalOpenTag=$this->mysqlOpenTag;
				$this->globalCloseTag= $this->mysqlCloseTag;
				break;
			case 'microsoft':
				$this->globalOpenTag=$this->sqlServerOpenTag;
				$this->globalCloseTag= $this->sqlServerCloseTag;
				break;
			case 'oracle':
				$this->globalOpenTag=$this->oracleOpenTag;
				$this->globalCloseTag= $this->oracleCloseTag;
				break;

		}
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
	public function connect($connection,$username,$database,$password) {
		$this->connection	=	$connection;
		$this->username		=	$username;
		$this->databaseName	=	$database;
		$this->password		=	$password;

		if($this->vendor=='normal')    {
			$this->link=mysql_connect($this->connection,$this->username,$this->password);
		}	elseif($this->vendor=='lite') {
			$this->link=mysqli_connect($this->connection,$this->username,$this->password,$this->databaseName,$this->port,$this->socket);
		} elseif($this->vendor=='microsoft') {

			$this->link= sqlsrv_connect($this->connection,array("UID" => $this->username, "PWD" => $this->password,"Database"=>$this->databaseName,"CharacterSet" => "UTF-8"
			));
		} else if ($this->vendor=='oracle') {
			/**
			 * Oracle doesn't required database is each user create have access...Kinda lame.SYSDBA also cannot access other user schema.
			 */
			$this->link =  oci_connect($this->username, $this->password, $this->connection);

		}
		if(!$this->link) {
			$this->execute='fail';

			if($this->vendor=='normal')    {
				$this->result_text=mysql_error($this->link)."Error Code".mysql_errno($this->link);
				echo json_encode(array("success"=>false,"message"=>$this->result_text));
				exit();
			}	elseif($this->vendor=='lite') {
				if (mysqli_connect_errno()) {
					$this->result_text=mysqli_connect_errno();
					echo json_encode(array("success"=>false,"message"=>'Fail To Connect Database : '.$this->result_text));
					exit();
				}
			} else if ($this->vendor=='microsoft') {
				$errorArray=array();
				$errorArray=sqlsrv_errors();
				$error.=" CE Sql State : ".$errorArray[0]['SQLSTATE'];
				$error.=" Code : ".$errorArray[0]['code'];
				$error.=" Message : ".$errorArray[0]['message'];
				$this->result_text=$error;
				echo json_encode(array("success"=>false,"message"=>'Fail To Connect Database : '.$this->result_text));
				exit();

			} else if($this->vendor=='oracle') {
				$errorArray	=	array();
				$errorArray	=	oci_error();
				$error.=	"Code: " . $errorArray["code"] . "<br>";
				$error.=	"Message: " . $errorArray["message"] . "<br>";
				$error.=	"Position: " . $errorArray["offset"] . "<br>";
				$error.=	"Statement: " . $errorArray["sqltext"] . "<br>";
				$this->result_text	=	$error;
				echo json_encode(array("success"=>false,"message"=>'Fail To Connect Database : '.$this->result_text));
				exit();
			}


		} else {
			if($this->vendor=="normal")   {
				$resources	=	mysql_select_db($this->databaseName,$this->link);
			} elseif($this->vendor=="lite") {
				$resources	=	mysqli_select_db($this->link,$this->databaseName);
			}
			if(!$resources) {
				if($this->vendor=='normal') {
					$this->result_text	=	mysql_error($this->link)."Error Code".mysql_errno($this->link);
					echo json_encode(array("success"=>false,"message"=>$this->result_text));
					exit();
				} elseif ($this->vendor	==	'lite'){
					$this->result_text	=	mysqli_error($this->link)."Error Code".mysqli_errno($this->link);
					echo json_encode(array("success"=>false,"message"=>$this->result_text));
					exit();
				}
			}
		}
	}

	/**
	 * Turns on or off auto-commit mode on queries for the database connection.

	 To determine the current state of autocommit use the SQL command SELECT @@autocommit.
	 */
	public function start(){
		
		if($this->vendor=="normal")   {
			mysql_query("SET autocommit=0",$this->link);
		} elseif($this->vendor=="lite") {
			mysqli_autocommit($this->link, FALSE);
		} elseif ($this->vendor =='microsoft') {
			if ( sqlsrv_begin_transaction( $this->link ) === false )	{
				$errorArray	=	array();
				$errorArray	=	sqlsrv_errors();
				$error.=	" TE Sql State : ".$errorArray[0]['SQLSTATE'];
				$error.=	" Code : ".$errorArray[0]['code'];
				$error.=	" Message : ".$errorArray[0]['message'];
				$this->result_text	=	$error;
				echo json_encode(array("success"=>false,"message"=>'Fail To Commit Transaction : '.$this->result_text));
				exit();
			}
		} elseif($this->vendor=='oracle') {
			/**
			 * oracle commit on oci_execute
			 */
			$this->oracleCommit=1;
		}
	}


	/**
	 * query database
	 * @param string $sql
	 * @param string $type
	 * to indentify the query is for view or total record.Available type 1. result type 2 total record
	 * @return number|Ambigous <NULL, resource>|unknown
	 */
	private function query($sql) {
		$this->sql				=	NULL;
		$this->type				=	NULL;
		$this->result			=	NULL;
		$this->countRecord		=	NULL;
		$this->sql				=	$sql;
		$error					= 0;
		if($this->vendor=='normal') {

			$this->result=mysql_query($this->sql,$this->link);
		} elseif($this->vendor=='lite') {
			$this->result	=mysqli_query($this->link,$this->sql);
		} elseif($this->vendor=='microsoft') {
			$this->result 	=	sqlsrv_query($this->link,$this->sql);
		} else if($this->vendor=='oracle') {

			$this->result = oci_parse($this->link,$this->sql);
			if($this->result != false) {
				$test =@oci_execute($this->result); //suspress warning message.Only handle by exception
				if($test){

				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($this->result);

					$error.=	"Code: " . $errorArray["code"] . "<br>";
					$error.=	"Message: " . $errorArray["message"] . "<br>";
					$error.=	"Position: " . $errorArray["offset"] . "<br>";
					$error.=	"Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error; // contain special character
					echo json_encode(array("success"=>false,"message"=>'Fail To Execute Query X : '.$this->result_text));
					exit();
				}
			} else {
				$errorArray	=	array();
				$errorArray	=	oci_error($this->result);
				$error.=	"Code: " . $errorArray["code"] . "<br>";
				$error.=	"Message: " . $errorArray["message"] . "<br>";
				$error.=	"Position: " . $errorArray["offset"] . "<br>";
				$error.=	"Statement: " . $errorArray["sqltext"] . "<br>";
				$this->result_text=$error;
				echo json_encode(array("success"=>false,"message"=>'Fail To Parse Query : '.$this->result_text));
				exit();
			}

		}
		if(!$this->result) {
			$this->execute='fail';
			if($this->vendor=='normal') {
				$this->result_text=mysql_error($this->link)."Error Code : ".mysql_errno($this->link);
				$error=1;
			}elseif($this->vendor=='lite') {
				$this->result_text="Sql Stament Error".$this->sql." \n\r".mysqli_error($this->link)." <br> Error Code :x ". mysqli_errno($this->link);
				$error=1;
			} else if ($this->vendor=='microsoft') {

				$this->result_text= " Query Error -> Sql State : ".$errorArray[0]['SQLSTATE']. " Code : ".$errorArray[0]['code']." Message : ".$errorArray[0]['message'];
				$error =1;

			}
		}
		if($this->log ==1 || $error ==1) {
		$sql_log="
					INSERT	INTO	".$this->globalOpenTag."log".$this->globalCloseTag."
								(
									".$this->globalOpenTag."leafId".$this->globalCloseTag.",
									".$this->globalOpenTag."operation".$this->globalCloseTag.",
									".$this->globalOpenTag."sql".$this->globalCloseTag.",
									".$this->globalOpenTag."date".$this->globalCloseTag.",
									".$this->globalOpenTag."staffId".$this->globalCloseTag.",
									".$this->globalOpenTag."log_error".$this->globalCloseTag."
								)
						values
								(
									\"".$this->leafId."\",
									\"".trim(addslashes($this->operation))."\",
									\"".trim(addslashes($this->sql))."\",
									\"".date("Y-m-d H:i:s")."\",
									\"".$this->staffId."\",
									\"".$this->realEscapeString($this->result_text)."\"
								)";
		//	print"<br><br><br>[]";
			if($this->vendor=='normal') {
				$result_row=mysql_query($sql_log,$this->link);
			} 	elseif($this->vendor=='lite') {
				$result_row=mysqli_query($this->link,$sql_log);
			}   elseif($this->vendor=='microsoft') {
				$result_row=sqlsrv_query($this->link,$sql_log);
			} else if($this->vendor=='oracle') {
				$result_row = oci_parse($this->link,$sql_log);
				if($result_row != false) {
					$test =@oci_execute($result_row); //suspress warning message.Only handle by exception
					if($test){
						//oracle don't have return resources.depend on oci_parse
					} else {
						$errorArray	=	array();
						$errorArray	=	oci_error($result_row);
						$error.=		"Code: " . $errorArray["code"] . "<br>";
						$error.=		"Message: " . $errorArray["message"] . "<br>";
						$error.=		"Position: " . $errorArray["offset"] . "<br>";
						$error.=		"Statement: " . addslashes($errorArray["sqltext"]) . "<br>";
						$this->result_text	=	$error;
						echo json_encode(array("success"=>false,"message"=>'Fail To PUT EXECUTE LOG: '.$this->result_text));
						exit();
					}
				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($result_row);
					$error.=	"Code: " . $errorArray["code"] . "<br>";
					$error.=	"Message: " . $errorArray["message"] . "<br>";
					$error.=	"Position: " . $errorArray["offset"] . "<br>";
					$error.=	"Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error;
					echo json_encode(array("success"=>false,"message"=>'Fail To Parse Query : '.$this->result_text));
					exit();
				}
			}
			if(!$result_row) {
				$this->execute='fail';
				if($this->vendor=='normal') {
					echo "error la query[".$sql_log."]";
					$this->result_text=$sql_log."<br>".mysql_error();

				}	elseif($this->vendor=='lite') {
					echo "error la query[".$sql_log."]";
					//		$this->result_text=$sql_log."<br>".mysqli_error($this->link)."<br> Error Code :y ".mysqli_errno($this->link);
				} else if ($this->vendor=='microsoft') {
					//		$this->result_text=sqlsrv_errors();
				}
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
	private function module($operation) {
		// for more secure option must SET at mysql access grant level
		// if 1 access granted which mean 1 record if null no mean no access to the db level
		$result_row			=	NULL;
		$this->operation	=	NULL;

		$sql="
				SELECT 	*
				FROM 	".$this->globalOpenTag."leafAccess".$this->globalCloseTag."
				WHERE  ".$this->globalOpenTag."leafAccess".$this->globalCloseTag.".".$this->globalOpenTag."leafId".$this->globalCloseTag."			=	'".$this->leafId."'
				AND   	".$this->globalOpenTag."leafAccess".$this->globalCloseTag.".".$this->globalOpenTag."".$operation."".$this->globalCloseTag."	=	'1'
				AND   	".$this->globalOpenTag."leafAccess".$this->globalCloseTag.".".$this->globalOpenTag."staffId".$this->globalCloseTag."		=	'".$this->staffId."'";


		if($this->vendor=='normal') {
			$result=mysql_query($sql,$this->link);
			if(!$result) {
				$this->execute='false';
				$this->result_text=$sql."x2<br>".mysql_error();
				$result_row=0;
			} else {
				$result_row=mysql_num_rows($result);
			}
		}elseif($this->vendor=='lite') {

			$result=mysqli_query($this->link,$sql);
			if(!$result) {
				$this->execute='false';
				$this->result_text=$sql.mysqli_error($this->link);
				$result_row=0;

			} else {

				$result_row=mysqli_num_rows($result);
			}

		} else if($this->vendor=='microsoft') {
			$result=sqlsrv_query($this->link,$sql ,array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET));
			if(!$result) {
				$this->execute='false';
				$errorArray	=	array();
				$errorArray	=	sqlsrv_errors();
				$error.=	" MS Sql State : ".$errorArray[0]['SQLSTATE'];
				$error.=	" Code : ".$errorArray[0]['code'];
				$error.=	" Message : ".$errorArray[0]['message'];
				$this->result_text	=	$error;
				$result_row=0;

			} else {


				$row_count = sqlsrv_num_rows( $result );
				if ($row_count === false)	{
					$this->result_text=$sql.sqlsrv_errors();
				}else if ($row_count >=0)	{
					$result_row=$row_count;
				}
			}
		} else if($this->vendor=='oracle') {
			$result = @oci_parse($this->link,$sql);
			if($result != false) {
				$test =@oci_execute($result); //suspress warning message.Only handle by exception
				if($test){
					//oracle don't have return resources.depend on oci_parse
					oci_fetch_all($result,$array);
					$result_row= oci_num_rows($result);
				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($result);

					$error.="Code: " . $errorArray["code"] . "<br>";
					$error.="Message: " . $errorArray["message"] . "<br>";
					$error.="Position: " . $errorArray["offset"] . "<br>";
					$error.="Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error;
					echo json_encode(array("success"=>false,"message"=>'Fail To Execute Query X : '.$this->result_text));
					exit();
				}
			} else {
				$errorArray	=	array();
				$errorArray	=	oci_error($result);
				$error.="Code: " . $errorArray["code"] . "<br>";
				$error.="Message: " . $errorArray["message"] . "<br>";
				$error.="Position: " . $errorArray["offset"] . "<br>";
				$error.="Statement: " . $errorArray["sqltext"] . "<br>";
				$this->result_text=$error;
				echo json_encode(array("success"=>false,"message"=>'Fail To Parse Query : '.$this->result_text));
				exit();
			}
		}

		if($result_row		==	1) {
			$access='Granted';
		}elseif($result_row	==	0) {
			$access='Denied';
		}




		/*
		 *  Only disable and Error Sql Statement will be log
		 */
		if($result_row == 0 || $this->log ==1 ) {

			// only trim out the last operation query.per limit query doesn't require because it's the same sql statement to track

			//	$operation = str_replace("leaf","",$operation);
			//	$operation = str_replace("Access","",$operation);
			//	$operation = str_replace("Value","",$operation);

			$sql_log="
								INSERT INTO ".$this->globalOpenTag."log".$this->globalCloseTag." (
											".$this->globalOpenTag."leafId".$this->globalCloseTag.",
											".$this->globalOpenTag."operation".$this->globalCloseTag.",
											".$this->globalOpenTag."sql".$this->globalCloseTag.",
											".$this->globalOpenTag."date".$this->globalCloseTag.",
											".$this->globalOpenTag."staffId".$this->globalCloseTag.",
											".$this->globalOpenTag."access".$this->globalCloseTag.",
											".$this->globalOpenTag."log_error".$this->globalCloseTag."
								) values (
											\"".$this->leafId."\",
											\"".$operation."\",
											\"".$this->realEscapeString($this->sql)."\",
											\"".date("Y-m-d H:i:s")."\",
											\"".$_SESSION['staffId']."\",
											\"".$access."\",
											\"".$this->realEscapeString($sql)."\")";
			if($this->vendor=='normal')    {




				mysql_query($sql_log,$this->link);

			}	elseif($this->vendor=='lite') {


				$test1=mysqli_query($this->link,$sql_log);
				if(!$test1){
					$this->execute='fail';
					$this->result_text=$sql_log."[".mysqli_error($this->link)."]";
				}
			}
		} else if ($this->vendor=='microsoft') {
			sqlsrv_query($this->link,$sql_log);
			$errorArray	=	array();
			$errorArray	=	sqlsrv_errors();
			$error.=	" IL Sql State : ".$errorArray[0]['SQLSTATE'];
			$error.=	" Code : ".$errorArray[0]['code'];
			$error.=	" Message : ".$errorArray[0]['message'];
			$this->result_text	=	$error;
		} else  if ($this->vendor=='oracle') {
			$result = oci_parse($this->link,$sql_log);
			if($result != false) {
				$test =@oci_execute($result); //suspress warning message.Only handle by exception
				if($test){
					//oracle don't have return resources.depend on oci_parse
				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($result);
					$error.="Code: " . $errorArray["code"] . "<br>";
					$error.="Message: " . $errorArray["message"] . "<br>";
					$error.="Position: " . $errorArray["offset"] . "<br>";
					$error.="Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error;
					echo json_encode(array("success"=>false,"message"=>'Fail To Execute Query ACCESS : '.$result));
					exit();
				}
			} else {
				$errorArray	=	array();
				$errorArray	=	oci_error($result);
				$error.="Code: " . $errorArray["code"] . "<br>";
				$error.="Message: " . $errorArray["message"] . "<br>";
				$error.="Position: " . $errorArray["offset"] . "<br>";
				$error.="Statement: " . $errorArray["sqltext"] . "<br>";
				$this->result_text=$error;
				echo json_encode(array("success"=>false,"message"=>'Fail To Prepara Query ACCESS :  : '.$result));
				exit();
			}
		}

		return($result_row);
	}
	/**
	 * this is for certain page which don't required to check access page
	 * @param string $sql
	 * @return resource
	 */
	public function queryPage($sql) {

		if(strlen($sql) > 0 ){
			$this->sql = $sql;
			return($this->query($this->sql));
		} else {
			$this->execute='fail';
			$this->result_text="Where's the query forgot Yax! ..[".$sql."]";
		}
	}
	/**
	 * for delete record
	 * @param string $sql
	 * @return sql statement
	 * @depreciated
	 */
	public function delete($sql) {
		if(strlen($sql)> 0 ){
			if($this->module('leafDeleteAccessValue')== 1) {
				$log_advance_type='D';
				$sql_column 	= "SHOW COLUMNS FROM `".$this->tableName."`";
				if($this->vendor=='normal'){
					$result_column 	= mysql_query($sql_column,$this->link);
				} else if ($this->vendor=='lite'){
					$result_column = mysqli_query($this->link,$sql_column);
				}
				if(!$result_column){
					$this->execute='fail';
					if($this->vendor='normal'){
						$this->result_text=mysql_error()."Error Code ".mysql_errno();
					} else {
						$this->result_text=mysqli_error($result_column). " Error Code".mysqli_errno($result_column);
					}
				} else {
					$field_val = array();
					if($this->vendor=='normal'){
						while ( $row_column  = mysql_fetch_array($result_column))  {
							// create the field value
							$field_val[]=  $row_column['Field'];
						}
					} else if ($this->vendor=='lite'){
						while ( $row_column  = mysqli_fetch_array($result_column))  {
							// create the field value
							$field_val[]=  $row_column['Field'];
						}
					}
				}

				$sql_prev =" SELECT * FROM `".$this->tableName."` WHERE `".$this->primaryKeyName."` = '".$this->primaryKeyValue."'";
				if($this->vendor=='normal'){
					$result_prev = mysql_query($sql_prev);
				}else if ($this->vendor=='lite'){
					$result_prev= mysqli_query($this->link,$sql_prev);
				}
				if(!$result_prev){
					$this->execute='fail';
					if($this->vendor='normal'){
						$this->result_text=mysql_error()."Error Code ".mysql_errno();
					} else {
						$this->result_text=mysqli_error($this->link). " Error Code".mysqli_errno($this->link);
					}
				} else {
					if($this->vendor=='normal'){
						while ( $row_prev = mysql_fetch_array($result_prev)) {
							foreach ($field_val as $field) {
								$text  .= "\"".$field."\":\"".$row_prev[$field]."\",";
								$prev[$field]=$row_prev[$field];
							}
						}
					} else if ($this->vendor=='lite'){

						while ( $row_prev = mysqli_fetch_array($result_prev)) {


							foreach ($field_val as $field) {
								$text  .= "\"".$field."\":\"".$row_prev[$field]."\",";
								$prev[$field]=$row_prev[$field];
							}
						}
					}
				}

				$text = substr($text,0,-1); // remove last coma
				$text = "{".$text."}"; // using json data format ?
				$sql_log_advance		=	 "
					INSERT INTO `log_advance`
							(
								`log_advance_text`,
								`log_advance_type`,
								`ref_uniqueId`
							)
					VALUES
							(
								'".$text."',
								'".$log_advance_type."',
								'".$this->leafId."'
							)";
				// here should create a backup file to restore back sql statement
				if($this->vendor=='normal') {
					$result=mysql_query($sql_log_advance,$this->link);
				}	elseif($this->vendor=='lite') {
					$result=mysqli_query($this->link,$sql_log_advance);
				}
				/**
				 *	sql not required because it parse from form itself
				 */
				if($this->vendor=='normal') {

					$result=mysql_query($sql,$this->link);
				}	elseif($this->vendor=='lite') {
					$result=mysqli_query($this->link,$sql);

				}

				if(!$result) {
					$this->execute=='fail';
					if($this->vendor=='normal') {
						$this->result_text=mysql_error()." Error Code".mysql_errno();
					} elseif($this->vendor=='lite') {
						// check back relationship database.cascading update,delete not done by now.dangerous
						$this->result_text= mysqli_error($this->link)."Error code".mysqli_errno($this->link);
						$this->rollback();
					}
				}
			}
			/*if($this->affectedRows() > 0 ){
				return $this->affectedRows();
				} else {
				$this->execute='fail';
				$this->result_text='Record not deleted because it\'s not founded.';
				}*/
		} else{
			$this->execute='fail';
			$this->result_text="Where's the query forgot Ya!";
		}

	}
	/**
	 * for insert record
	 * @param string $sql
	 * @return sql statement
	 */
	public function create($sql) {
		$this->sql	=	NULL;
		$this->sql	=	$sql;
		if(strlen($sql)> 0 ){



			if(	$this->module('leafCreateAccessValue')	==	1) {
				return($this->query($this->sql));
			}	else{
				echo "no access insert ";
			}
		} else {
			$this->execute='fail';
			$this->result_text="Where's the query forgot Ya!";
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
	public function update($sql) {
		$this->sql	=	NULL;
		$this->sql	=	$sql;
		if(strlen($sql)> 0) {

			if(	$this->module('leafUpdateAccessValue')	==	1) {
				if($this->audit == 1 ){
					$log_advance_type 	= 'U'; // aka update
					$sql_column 	= "SHOW COLUMNS FROM `".$this->tableName."`";
					if($this->vendor=='normal'){
						$result_column 	= mysql_query($sql_column,$this->link);
						if(!$result_column){
							$this->execute='fail';
							$this->result_text="Error selecting table";
						}
					} else if($this->vendor=='lite'){
						$result_column = mysqli_query($this->link,$sql_column);
						if(!$result_column){
							$this->execute='fail';
							$this->result_text="Error selecting table";
						}
					}

					$field_val = array();
					if($this->vendor=='normal') {
						if(!$result_column){
							$this->execute='fail';
							$this->result_text=mysql_error()."Error Code".mysql_errno();
						}else {
							while ( $row_column  = mysql_fetch_array($result_column))  {
								// create the field value
								$field_val[]=  $row_column['Field'];

							}
						}
					} elseif ($this->vendor=='lite'){

						if(!$result_column){
							$this->execute='fail';
							$this->result_text=mysqli_error($this->link)."Error Code".mysqli_errno($$this->link);
						} else {
							//	echo "Jumlah Rekod".mysqli_num_rows($result_column);
							while ( $row_column  = mysqli_fetch_array($result_column))  {
								// create the field value

								$field_val[]=  $row_column['Field'];

							}
						}
					}


					$sql_prev ="
					SELECT 	*
					FROM 	`".$this->tableName."`
					WHERE 	`".$this->primaryKeyName."` = '".$this->primaryKeyValue."'";

					if($this->vendor=='normal'){
						$result_prev = mysql_query($sql_prev,$this->link);
						if(!$result_prev){
							$this->execute='fail';
							$this->result_text=mysql_error." Error Code".mysql_errno();
						}else {
							while ( $row_prev = mysql_fetch_array($result_prev)) {
								foreach ($field_val as $field) {
									$text  .= "\"".$field."\":\"".$row_prev[$field]."\",";
									$prev[$field]=$row_prev[$field];
								}
							}
						}
					}else if($this->vendor=='lite') {

						$result_prev = mysqli_query($this->link,$sql_prev);
						if(!$result_prev){
							$this->execute='fail';
							$this->result_text=mysqli_error($this->link)."Error Code".mysqli_errno($this->link);
						} else {
							// successfully

							//	echo "Jumlah Rekod ".mysqli_num_rows($result_prev);
							while ( $row_prev = mysqli_fetch_array($result_prev)) {

								foreach ($field_val as $field) {
									$text  .= "\"".$field."\":\"".$row_prev[$field]."\",";
									$prev[$field]=$row_prev[$field];
								}
							}
						}
					}

					$text = $this->removeComa($text);
					$text = "{".$text."}"; // using json data format ?
					$sql_log_advance		=	 "
					INSERT INTO 	`log_advance`
					(
					`log_advance_text`,
					`log_advance_type`,
					`ref_uniqueId`
					)
					VALUES 		(
					'".$text."',
					'".$log_advance_type."',
					'".$this->leafId."'
					)";
					if($this->vendor=='normal'){
						$result_log_advance 	=	 mysql_query($sql_log_advance,$this->link);
						if($result_log_advance){
							$log_advance_uniqueId 	= 	 mysql_insert_id(); // take the last id for references
						}else {
							$this->execute='fail';
							$this->result_text="Error inserting Query Advance insert";
						}
					}else if($this->vendor=='lite') {
						$result_log_advance 	=	 mysqli_query($this->link,$sql_log_advance);
						if($result_log_advance){

							// take the last id for references

							$log_advance_uniqueId 	= 	 mysqli_insert_id($this->link); //
						}else {
							$this->execute='fail';
							$this->result_text="error inserting query update insert";
						}
					}
				}
				$this->query($this->sql);
				$record_affected = $this->affectedRows(); // direct call for can now how much record have been deleted and make error handling
				if($this->audit==1){
					// select the current update file
					$sql_curr="
					SELECT 	*
					FROM 	`".$this->tableName."`
					WHERE 	`".$this->primaryKeyName."`='".$this->primaryKeyValue."'";
					if($this->vendor=='normal'){
						$result_curr  = mysql_query($sql_curr,$this->link);
						if($result_curr) {
							while	($row_curr = mysql_fetch_array($result_curr)) {
								$text_comparison.= $this->compare($field_val, $row_curr, $prev);

							}
						} else {
							$this->execute='fail';
							$this->result_text="Error Query on advance select";
						}
					} else if($this->vendor=='lite'){
						$result_curr  = mysqli_query($this->link,$sql_curr);
						if($result_curr){
							while	($row_curr = mysqli_fetch_array($result_curr)) {
								$text_comparison.= $this->compare($field_val, $row_curr, $prev);
							}
						}else {
							$this->execute='fail';
							$this->result_text="Error Query on advance select".$sql_curr;
						}
					}
					$text_comparison = substr($text_comparison,0,-1); // remove last coma
					$text_comparison = "{ \"tablename\":\"".$this->tableName."\",\"ref_uniqueId\":\"".$this->primaryKeyValue."\",".$text_comparison."}"; // json format
					// update back comparision the previous record
					$sql="
					UPDATE	`log_advance`
					SET 	`log_advance_comparison`='".addslashes($text_comparison)."'
					WHERE 	`log_advance_uniqueId`='".$log_advance_uniqueId."'";
					if($this->vendor=='normal'){
						$result=mysql_query($sql,$this->link);
						if(!$result) {
							$this->execute='fail';
							$this->result_text="Error Query update log advance";
						}

					} else if($this->vendor=='lite'){
						$result= mysqli_query($this->link,$sql);
						if(!$result){
							$this->execute='fail';
							$this->result_text="Error Query update log advance";
						}
					}

				}
			}else {
				$this->execute='fail';
				$this->result_text='access denied lol';
			}
			return $record_affected;
		} else {
			$this->execute='fail';
			$this->result_text="Where's the query forgot Ya!";
		}
	}

	/**
	 * for view record
	 * @param string $sql
	 * @return sql statement
	 */
	public function read($sql) {
		/**
		 *  initilize dummy value
		 * @var string sql
		 */
		$this->sql	=	NULL;
		/**
		 *  redefine variable
		 * @var string sql
		 */
		$this->sql	=	$sql;
		/**
		 *  initilize dummy value for database column access value.
		 * @var string type
		 */
		$type		=  NULL;
		/*
		 *  Test string of sql statement.If forgot or not
		 */
		if(strlen($sql)> 0 ) {


			if(	$this->module('leafReadAccessValue')	==	1) {

				return($this->query($this->sql));
			} else {
				$this->execute='fail';
				$this->result_text=" Access Denied View ";
			}
		} else {
			$this->execute='fail';
			$this->result_text="Where's the query forgot Ya!";
		}
	}
	public function file($sql) {
		$this->sql	=	NULL;
		$this->sql	=	$sql;
		/*
		 *  check if the programmer put query on sql or not
		 */
		if(strlen($sql)> 0 ) {
			if($this->vendor=='normal') {
				$result = mysql_query($this->sql,$this->link);
			}else if($this->vendor=='lite') {
				$result = mysqli_query($this->link,$this->sql);
			} else if ($this->vendor=='microsoft') {
				$result = sqlsrv_query($this->link,$this->sql);
			} else if($this->vendor=='oracle') {
				$result = oci_parse($this->link,$this->sql);
				oci_execute($result);
			}
			return $result;
		} else {
			$this->execute='fail';
			$this->result_text="Where's the query forgot Ya!";
		}
	}

	/**
	 * Fast Query Without Log and Return like normal resources query
	 * @param string $sql
	 * @return resource
	 */
	public function fast($sql) {
		$this->sql	=	NULL;
		$this->sql	=	$sql;
		/*
		 *  check if the programmer put query on sql or not
		 */
		if(strlen($sql)> 0 ) {

			if($this->vendor=='normal') {

				$result = mysql_query($this->sql,$this->link);

			}
			else if($this->vendor=='lite') {
				$result = mysqli_query($this->link,$this->sql);

			} else if ($this->vendor=='microsoft') {
				$result = sqlsrv_query($this->link,$this->sql,array(), array( "Scrollable" =>SQLSRV_CURSOR_KEYSET));

			} else if($this->vendor=='oracle') {
				$result = oci_parse($this->link,$this->sql);
				if($result != false) {
					$test =oci_execute($result); //suspress warning message.Only handle by exception
					if($test){
						//oracle don't have return resources.depend on oci_parse
					} else {
						$errorArray	=	array();
						$errorArray	=	oci_error($result);

						$error.="Code: " . $errorArray["code"] . "<br>";
						$error.="Message: " . $errorArray["message"] . "<br>";
						$error.="Position: " . $errorArray["offset"] . "<br>";
						$error.="Statement: " . $errorArray["sqltext"] . "<br>";
						$this->result_text=$error;
						echo json_encode(array("success"=>false,"message"=>'Fail To Execute Query X : '.$this->result_text));
						exit();
					}
				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($result);
					$error.="Code: " . $errorArray["code"] . "<br>";
					$error.="Message: " . $errorArray["message"] . "<br>";
					$error.="Position: " . $errorArray["offset"] . "<br>";
					$error.="Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error;
					echo json_encode(array("success"=>false,"message"=>'Fail To Parse Query : '.$this->result_text));
					exit();
				}

			}
			return $result;
		} else {
			$this->execute='fail';
			$this->result_text="Where's the query forgot Ya!";
		}
	}

	/**
	 * Retrieves the number of rows from a result set. This command is only valid for statements like SELECT or SHOW that return an actual result set.
	 * @params $result  result from the query
	 *  @params $sql  Previous Sql  Statement.Only valid for oracle database
	 * @return number`
	 *  @version 0.1 add result for query doesn't require log future
	 */
	public function numberRows($result=null,$sql=null){
		if($result) {
			if($this->vendor=='normal') {
				$this->countRecord = mysql_num_rows($result);
			} else if ($this->vendor=='lite') {
				$this->countRecord = mysqli_num_rows($result);
			} else if ($this->vendor=='microsoft') {

				$row_count = sqlsrv_num_rows( $result );
				if ($row_count === false)	{
					echo print_r(sqlsrv_errors());
				}else if ($row_count >=0)	{
					$this->countRecord=$row_count;
				}
			}	else if ($this->vendor=='oracle') {
				/**
				 * oracle have limitation on this query have to query twice
				 */


				$result = oci_parse($this->link,$sql);
				if($result != false) {
					$test =oci_execute($result); //suspress warning message.Only handle by exception
					if($test){
						//oracle don't have return resources.depend on oci_parse
						oci_fetch_all($result,$array);
						$this->countRecord= oci_num_rows($result);
						//echo "Total record [".$this->countRecord."]";
					} else {
						$errorArray	=	array();
						$errorArray	=	oci_error($result);

						$error.="Code: " . $errorArray["code"] . "<br>";
						$error.="Message: " . $errorArray["message"] . "<br>";
						$error.="Position: " . $errorArray["offset"] . "<br>";
						$error.="Statement: " . $errorArray["sqltext"] . "<br>";
						$this->result_text=$error;
						echo json_encode(array("success"=>false,"message"=>'Fail To Execute Query X : '.$this->result_text));
						exit();
					}
				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($result);
					$error.="Code: " . $errorArray["code"] . "<br>";
					$error.="Message: " . $errorArray["message"] . "<br>";
					$error.="Position: " . $errorArray["offset"] . "<br>";
					$error.="Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error;
					echo json_encode(array("success"=>false,"message"=>'Fail To Parse Query : '.$this->result_text));
					exit();
				}



			}
		}  else{
			if($this->vendor=='normal') {
				$this->countRecord = mysql_num_rows($this->result);
			} else if ($this->vendor=='lite') {

				$this->countRecord = mysqli_num_rows($this->result);
			} else if ($this->vendor=='microsoft') {
				$result	=	sqlsrv_query($this->link,$this->sql ,array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET));
				$row_count = sqlsrv_num_rows( $result );
				if ($row_count === false)	{
					echo print_r(sqlsrv_errors());
				}else if ($row_count >=0)	{
					$this->countRecord=$row_count;
				}
			}	else if ($this->vendor=='oracle') {
				/**
				 * oracle have limitation on this query have to query twice
				 */


				$oracleNumRows = oci_parse($this->link,$this->sql);
				if($oracleNumRows != false) {
					$test =oci_execute($oracleNumRows); //suspress warning message.Only handle by exception
					if($test){
						//oracle don't have return resources.depend on oci_parse
						oci_fetch_all($oracleNumRows,$array);
						$this->countRecord= oci_num_rows($oracleNumRows);
						//	echo "Total record [".$this->countRecord."]";
					} else {
						$errorArray	=	array();
						$errorArray	=	oci_error($oracleNumRows);

						$error.="Code: " . $errorArray["code"] . "<br>";
						$error.="Message: " . $errorArray["message"] . "<br>";
						$error.="Position: " . $errorArray["offset"] . "<br>";
						$error.="Statement: " . $errorArray["sqltext"] . "<br>";
						$this->result_text=$error;
						echo json_encode(array("success"=>false,"message"=>'Fail To Execute Query X : '.$this->result_text));
						exit();
					}
				} else {
					$errorArray	=	array();
					$errorArray	=	oci_error($oracleNumRows);
					$error.="Code: " . $errorArray["code"] . "<br>";
					$error.="Message: " . $errorArray["message"] . "<br>";
					$error.="Position: " . $errorArray["offset"] . "<br>";
					$error.="Statement: " . $errorArray["sqltext"] . "<br>";
					$this->result_text=$error;
					echo json_encode(array("success"=>false,"message"=>'Fail To Parse Query : '.$this->result_text));
					exit();
				}



			}
		}
		return($this->countRecord);
	}

	/**
	 * Retrieves the ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).
	 * @return number
	 */
	public function lastInsertId(){
		// must include this before q->commit; after commit will no output
		if($this->vendor =='normal') {
			$this->insert_id	= mysql_insert_id();
		} else  if ($this->vendor=='lite') {
			$this->insert_id 	= mysqli_insert_id($this->link);

		} else if ($this->vendor=='microsoft') {
			$resultId = sqlsrv_query("SELECT LAST_INSERT_ID=@@IDENTITY");
			$rowId = sqlsrv_fetch_array($resultId,SQLSRV_FETCH_ASSOC);
			$this->insert_id =$rowId['LAST_INSERT_ID'];
		}else if ($this->vendor=='oracle') {
			$resultId = oci_parse($this->link,"SELECT '".$sequence.".CURRVAL FROM DUAL");
			oci_execute($resultId);
			/**
			 * optional constant OCI_BOTH,OCI_ASSOC,OCI_NUM,OCI_RETURN_NULLS,OCI_RETURN_LOBS
			 */
			$row=oci_fetch_assoc($resultId,'OCI_BOTH');
			$this->insert_id= $row['CURRVAL'];
		}
		//	echo "This come from class ".$this->insert_id;
		return $this->insert_id;
	}
	/**
	 * Get the number of affected rows by the last INSERT, UPDATE, REPLACE or DELETE query associated with link_identifier.
	 * By default  if not changes the affected rows are null but in this system effected also because of update time and create time.Consider not harmfull bug.
	 */
	public function affectedRows(){
		if($this->vendor =='normal') {
			return mysql_affected_rows();
		} else if($this->vendor=='lite'){

			return mysqli_affected_rows($this->link);

		}
		// no information from sql server
	}

	/**
	 * Commits the current transaction for the database connection.
	 */
	public function commit() {
		// this is begun statement
		if($this->vendor=='normal')  {
			mysql_query("SET autocommit=1",$this->link);
		} else  if ($this->vendor=='lite'){
			mysqli_commit($this->link);
		} else if ($this->vendor=='microsoft') {
			sqlsrv_commit($this->link);
		} else if ($this->vendor=='oracle') {
			oci_commit($this->link);
		}
	}
	/**
	 * Rollbacks the current transaction for the database.
	 */
	private function rollback() {
		// in mysql there are no indicator rollback list.rollbak only available in current transaction only
		if($this->vendor=='normal')  {
			mysql_query("ROLLBACK", $this->link);
			$this->execute='fail';
		} else if($this->vendor=='lite') {
			mysqli_rollback($this->link);
			$this->execute='fail';
		} else if ($this->vendor=='microsoft') {
			sqlsrv_rollback($this->link);
			$this->execute='fail';
		}else if ($this->vendor='oracle') {
			oci_rollback($this->link);
			$this->execute='fail';
		}
	}
	/**
	 * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead. mysql_fetch_assoc() is equivalent to calling mysql_fetch_array() with MYSQL_ASSOC for the optional second parameter. It only returns an associative array
	 * @return array
	 * version 0.1 added result future
	 */
	public function fetchArray($result=null) {
		if($this->vendor =='normal') {
			if($this->result)	{  return mysql_fetch_array($this->result); }
			if($result) 		   	{  return mysql_fetch_array($result); }
		} elseif ($this->vendor=='lite') {
			if($this->result)	{  return @mysqli_fetch_array($this->result); }
			if($result) 		   	{  return @mysqli_fetch_array($result); }
		} elseif($this->vendor=='microsoft') {
			if($this->result)	{  return @sqlsrv_fetch_array($this->result,SQLSRV_FETCH_BOTH); }
			if($result) 			{	return @sqlsrv_fetch_array($result,SQLSRV_FETCH_BOTH); }
		}elseif($this->vendor=='oracle') {
			if($this->result)	{  return oci_fetch_array($this->result,OCI_BOTH); }
			if($result) 			{	return oci_fetch_array($result,OCI_BOTH); }
		}
	}
	/**
	 *
	 *  this only solve problem if  looping /inserting data.result error
	 *  @version 0.1 using  fetch_array
	 *  @version 0.2 using fetch_assoc  for faster json
	 *	@version 0.3 added result future .No Sql Logging
	 */
	public function activeRecord($result=null) {
		$d=array();
		if($this->vendor =='normal') {
			if($result) {

				while($row=mysql_fetch_assoc($result)){
					$d[]=$row;
				}
			} else {

				while($row=mysql_fetch_assoc($this->result)){
					$d[]=$row;
				}
			}
		}elseif ($this->vendor=='lite') {
			if($result) {
				while($row=mysqli_fetch_assoc($result)){
					$d[]=$row;
				}
			} else {
				while($row=mysqli_fetch_assoc($this->result)){
					$d[]=$row;
				}
			}
			return $d;
		}elseif ($this->vendor=='microsoft') {
			if($result) {
				while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
					$d[]=$row;
				}
			} else {
				while($row=sqlsrv_fetch_array($this->result,SQLSRV_FETCH_ASSOC)){
					$d[]=$row;
				}
			}

		} elseif($this->vendor=='oracle') {
			if($result) {
				while($row=oci_fetch_array($result,OCI_ASSOC)){
					$d[]=$row;
				}
			} else {
				while($row=oci_fetch_array($this->result,OCI_ASSOC)){
					$d[]=$row;
				}
			}
		}
		return $d;
	}
	/**
	 * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead. mysql_fetch_assoc() is equivalent to calling mysql_fetch_array() with MYSQL_ASSOC for the optional second parameter. It only returns an associative array
	 * @version 0.1 added result future.No Sql Logging
	 * @return array
	 */
	public function fetchAssoc($result=null) {
		// tried consept push to array and sending array back

		if($this->vendor =='normal') {
			if($this->result && is_null($result)) { return mysql_fetch_assoc($this->result);  }
			if($result) { return mysql_fetch_assoc($result); }
		} elseif ($this->vendor=='lite') {
			if($this->result && is_null($result)) {
				
				 return mysqli_fetch_assoc($this->result); }
			if($result) {
				
				 return mysqli_fetch_assoc($result); }

		}
		elseif ($this->vendor=='microsoft') {
			if($this->result && is_null($result)) { return sqlsrv_fetch_array($this->result,SQLSRV_FETCH_ASSOC); }
			if($result) { return sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC); }

		} elseif($this->vendor=='oracle') {
			if($this->result && is_null($result)) { return oci_fetch_assoc($this->result); }
			if($result) {  return oci_fetch_assoc($result); }
		}

	}
	/**
	 * Frees the memory associated with the result.
	 * @version 0.1 added result future.No Sql Logging
	 */
	public function freeResult($result=null) {
		// free memory  location
		if($this->vendor=='normal') {
			if($this->result) { mysql_free_result($this->result);  }
			if($result) { mysql_free_result($result);  }
		} elseif($this->vendor=='lite') {
			if($this->result) {  mysqli_free_result($this->result); }
			if($result) {  mysqli_free_result($result); }
		} elseif($this->vendor=='microsoft'){
			if($this->result) { sqlsrv_free_stmt($this->result); }
			if($result) { sqlsrv_free_stmt($result); }
		} elseif($this->vendor=='oracle') {
			/*	if($this->result) { sqlsrv_free_stmt($this->result); }
			 if($result) { sqlsrv_free_stmt($result); }
			 */
		}
	}
	/**
	 * Closes a previously opened database connection
	 */
	public function close($result=null) {
		// close mysql connections
		if($this->vendor=='normal')  {
			$result=mysql_close($this->link);
		} elseif($this->vendor=='lite') {
			$result=mysqli_close($this->link);
		} elseif($this->vendor=='microsoft'){
			$result = sqlsrv_close($this->link);
		} elseif($this->vendor=='oracle') {
			$result= oci_close($this->link);
		}
		//reSETing null too free up resouces
		$result=null;
		$this->link=null;
	}

	/**
	 * To compare value from old value and new value
	 * @param string field vale come from column name
	 * @param string curr_value come from mysql loop
	 * @param string prev_value come from first value before edit.
	 * @return string
	 */
	private function compare($field_val,$curr_value,$prev_value){
		foreach ($field_val as $field) {

			switch ($curr_value[$field]) {
				case is_float($curr_value[$field]):
					// $type='float';
					$type='double';
					$type='integer';
					$diff=	$curr_value[$field]-$prev_value[$field];
					break;
				case is_numeric($curr_value[$field]):
					$type='integer';
					$diff=	$curr_value[$field]-$prev_value[$field];
					break;
				case $this->isDatetime($curr_value[$field]):
					$type='datetime';
					$DownTime =  strtotime($curr_value[$field]) - strtotime($prev_value[$field]);
					$days = floor($DownTime / 86400); //    60*60*24 is one day
					$SecondsRemaining = $DownTime % 86400;
					$hours = floor($SecondsRemaining / 3600);    // 60*60 is one hour
					$SecondsRemaining = $SecondsRemaining % 3600;
					$minutes = floor($SecondsRemaining / 60);    // minutes
					$seconds = $SecondsRemaining % 60;
					if ($days > 0) {
						$days = $days . ", ";
					}	else {
						$days = NULL;
					}
					$diff = $days . $hours . ":" . $minutes . ":" . $seconds;



					break;
				case is_string($curr_value[$field]):
					$type='string';
					$diff="No Checking Please";
					break;
				case is_array($curr_value[$field]):
					$type='array';
					$diff="No Checking Please";
					break;
				case is_null($curr_value[$field]):
					$type='NULL';
					$diff="Record have been empty";
					break;
				case is_bool($curr_value[$field]):
					$type='boolean';
					$diff="Cannot Compare bolean record";
					break;


				case is_object($curr_value[$field]):
					$type='object';
					$diff="Something wrong here why object";
					break;

				case is_resource($curr_value[$field]):
					$type='resource';
					$diff="Something wrong here why object";
					break;

				default:
					$type='unknown type';
					$diff="System Headache Cannot Figure out  :(";
					break;
			}
			// json format ?
			$text_comparison  .= "\"".$field."\":[{ \"prev\":\"".$prev_value[$field]."\"},
														{ \"curr\":\"".$curr_value[$field]."\"},
														{ \"type\":\"".$type."\"},
														{ \"diff\":\"".$diff."\"}],";
		}
		return $text_comparison;
	}
	private function realEscapeString($data) {
		if($this->vendor=='normal'){
			return mysql_escape_string($data);
		}
		if($this->vendor=='lite'){

			return mysqli_real_escape_string($this->link,$data);
		}
		if($this->vendor=='microsoft') {
			$singQuotePattern = "'";
			$singQuoteReplace = "''";
			return(stripslashes(eregi_replace($singQuotePattern, $singQuoteReplace, $data)));
		}
		if($this->vendor=='oracle'){

			return str_replace("\"", "\\\"", $data);
		}

	}
	/**
	 * to send filter result.Quick Search mode
	 * @params array $tableArray
	 * @params array $filterArray
	 * @return string filter
	 */


	public function quickSearch($tableArray,$filterArray){
		$i		   =	0;
		$strSearch = null;
		$strSearch = "AND ( ";

		foreach ($tableArray as $tableSearch){
			if($this->vendor=='normal' || $this->vendor=='lite') {
				$sql="DESCRIBE	`".$tableSearch."`";
			} else if ($this->vendor=='microsoft') {
				$sql="
				select *
  				from information_schema.columns
 				where table_name = ".$tableSearch."
 				order by ordinal_position";
			} else if ($this->vendor=='oracle') {
				$sql="DESCRIBE	\"".$tableSearch."\"";
			}
			$this->query_view($sql);
			if($this->num_rows() > 0 ) {

				while($row = $this->fetch_array()) {

					if($this->vendor=='normal' || $this->vendor=='lite') {
						$strField 	= "`".$tableSearch."`.`".$row['Field']."`";
					} else if ($this->vendor=='microsoft') {
						$strField 	= "[".$tableSearch."].[".$row['COLUMN_NAME']."]";
					} else if ($this->vendor=='oracle') {
						$strField 	= "\"".$tableSearch."\".\"".$row['Name']."\"";
					}
					$key = array_search($strField,$filterArray,true);
					if($i > 0 && strlen($key) ==0) {
						$strSearch.=" OR  ";
					}

					if(strlen($key) == 0) {
						$strSearch.=$strField." like '%".$this->quickFilter."%'";
					}
					$i++;
				}
			} else {
				echo "something wrong here";
			}

		}

		$strSearch.=")";
		return $strSearch;

	}
	/**
	 * to send filter result.
	 * @return string filter
	 */
	public function searching() 						{
		$filter=$this->filter;
		if (is_array($filter)) {
			for ($i=0;$i<count($filter);$i++){
				switch($filter[$i]['data']['type']){
					case 'string' :

						$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." LIKE '%".$this->realEscapeString($filter[$i]['data']['value'])."%'";


						break;
					case 'list' :
						$split  = explode(",",$filter[$i]['data']['value']);
						foreach($split as $split_a)   {
							$str .= "'".$split_a."',";
						}
						$str = $this->removeComa($str);
						if(count($split) > 0  && strlen($filter[$i]['data']['value']) > 0 ) {
							$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag."  IN ($str)";

						}
						break;
					case 'boolean' :


						$qs .= " AND ".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." = ".$this->realEscapeString($filter[$i]['data']['value']);


						break;
					case 'numeric' :
						switch ($filter[$i]['data']['comparison']) {
							case 'ne' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." != ".$this->realEscapeString($filter[$i]['data']['value']);


								break;
							case 'eq' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." = ".$this->realEscapeString($filter[$i]['data']['value']);


								break;
							case 'lt' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." < ".$this->realEscapeString($filter[$i]['data']['value']);


								break;
							case 'gt' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." > ".$this->realEscapeString($filter[$i]['data']['value']);


								break;
						}
						break;
					case 'date' :
						switch ($filter[$i]['data']['comparison']) {
							case 'ne' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." != '".date('Y-m-d',strtotime($filter[$i]['data']['value']))."'";
								break;
							case 'eq' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." = '".date('Y-m-d',strtotime($filter[$i]['data']['value']))."'";
								break;
							case 'lt' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." < '".date('Y-m-d',strtotime($filter[$i]['data']['value']))."'";
								break;
							case 'gt' :
								$qs .= " AND ".$this->globalOpenTag.$filter[$i]['table'].$this->globalCloseTag.".".$this->globalOpenTag.$filter[$i]['column'].$this->globalCloseTag." > '".date('Y-m-d',strtotime($filter[$i]['data']['value']))."'";
								break;
						}
						break;
				}
			}
			//$where .= $qs;
		}
		if(isset($qs)) {
			return $qs;
		}
	}
/**
	 * Checking date if  true or false
	 * @param date $dateTime
	 * @return boolean
	 */
	public function isDatetime($dateTime)	{
		if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches))	{
			if (checkdate($matches[2], $matches[3], $matches[1]))	{
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
	public function removeComa($str) {
		return	substr($str,0,-1);
	}

}

?>
