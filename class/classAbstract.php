<?php
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
date_default_timezone_set("Asia/Kuala_Lumpur");
require_once('classMysql.php');
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
/**
 * Database Configuration File and Database
 * @author hafizan
 *
 */
abstract class configClass
{
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $value;
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $type;
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $connection;
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $database;
    public $username;
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $password;
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $staffId;
    /**
     * Enter description here ...
     * @var unknown_type
     */
    public $currUserSession;
    /**
     * Path Of the application
     * @var string $application
     */
    public $application;
    /**
     * Mysql Database
     * @var const string
     */
    const mysql ='mysql';
     /**
     * Microsoft Sql Server Database
     * @var const string
     */
    const mssql ='microsoft';
     /**
     * Oracle Database
     * @var const string
     */
    const oracle = 'oracle';
    // end basic access database
    
    /*
     *   @version  0.1  filter strict php setting
     */
    function __construct()
    {
        //optional
        $this->connection = 'localhost';
        //	$this->connection   =  'UK0EG6KHE48\LOCALHOST'; // this is for Microsoft Sql Server Testing.
        if (isset($_SESSION['database'])) {
            $this->database = $_SESSION['database'];
        }
        if (isset($_SESSION['staffId'])) {
            $this->currUserSession = $_SESSION['staffId'];
        }
        $this->currUserSession = $_SESSION['staffId'];
        $this->username        = 'root';
        //$this->username ='JOKERS'; // testing for oracle
        $this->password        = '123456';
        //	$this->password="pa\$\$word4sph";
        $this->application     = 'idcmsCore';
        // define method
    }
    /**
     * New Record From Database
     */
    abstract protected function create();
    /**
     * Read Record From Databaase
     */
    abstract protected function read();
    /**
     * Update Record From Database
     */
    abstract protected function update();
    /**
     * Delete Record From Database
     */
    abstract protected function delete();
    /**
     * Microsoft Excel 2007 Ouput File Generation
     */
    abstract protected function excel();
    /**
     *  Return Staff Name
     */
    public function staffId()
    {
        header('Content-Type', 'application/json; charset=utf-8');
        if ($this->q->vendor == 'mysql') {
            $sql = "
			SELECT 	`staffId`,
					`staffNo`,
					`staffName`
			FROM   	`staff`
			WHERE	`isActive`=1";
        } else if ($this->q->vendor == 'microsoft') {
            $sql = "
			SELECT 	[staffId],
					[staffNo],
					[staffName]
			FROM   	[staff]
			WHERE  	[isActive]=1";
        } else if ($this->q->vendor == 'oracle') {
            $sql = "
			SELECT 	\"staffId\",
					\"staffNo\",
					\"staffName\"
			FROM   	\"staff\"
			WHERE  	\"isActive\"=1";
        }
        $result = $this->q->fast($sql);
		$total = $this->q->numberRows($result);
        $items  = array();
        while ($row = $this->q->fetchAssoc($result)) {
            $items[] = $row;
        }
        echo json_encode(array(
            'success' => true,
			'total'=>$total,
			'message'=>'Data loaded',
            'staff' => $items
        ));
    }
    /**
     * to filter data type.
     * @param value $v
     * value variable come from server request or variable
     * @param type $t
     * Available data type password or p ,
     *                     numeric  or n,
     *                     booleand or b,
     *                     string   or s,
     *                     wyswg    or w
     *                     memo     or m,
     *                     float    or f,
     *                     date     or d
     *                     username or u
     *                     calender or
     *                     web      or wb
     *					  iconname   or i
     * * @version 0.1 addd filter addslasshes
     * @return NULL|string|Ambigous <NULL, number, value, string, mixed>|number|unknown
     */
    public function strict($v, $t)
    {
        $this->value = $v;
        $this->type  = $t;
        // short form code available
        if ($this->type == 'password' || $this->type == 'p') {
            if (strlen($this->value) != 32) {
                if (empty($this->value)) {
                    return null;
                }
            }
            return (addslashes($this->value));
        } elseif ($this->type == 'numeric' || $this->type == 'n') {
            if (!is_numeric($this->value)) {
                $this->value = 0;
                return ($this->value);
            } else {
                return (intval($this->value));
            }
        } elseif ($this->type == 'boolean' || $this->type == 'b') {
            if ($this->value == 'true') {
                return 1;
            } elseif ($this->value) {
                return 0;
            }
        } elseif ($this->type == 'string' || $this->type == 's') {
            if (empty($this->value) && (strlen($this->value) == 0)) {
                $this->value = null;
                return ($this->value);
            } elseif (strlen($this->value) == 0) {
                $this->value = null;
                return ($this->value);
            } else {
                //UTF8 bugs
                //$this->value=trim(strtoupper($this->value)); // trim any space better for searching issue
                $this->value = addslashes($this->value);
                return $this->value;
            }
        } else if (($this->type == 'email' || $this->type == 'e') || ($this->type == 'filename' || $this->type == 'f') || ($this->type == 'iconname' || $this->type == 'i') || ($this->type == 'calendar' || $this->type == 'c') || ($this->type == 'username' || $this->type == 'u') || ($this->type == 'web' || $this->type == 'wb')) {
            if (empty($this->value) && (strlen($this->value) == 0)) {
                $this->value = null;
                return ($this->value);
            } elseif (strlen($this->value) == 0) {
                $this->value = null;
                return ($this->value);
            } else {
                $this->value = trim($this->value); // trim any space better for searching issue
                return $this->value;
            }
        } elseif ($this->type == 'wyswyg' || $this->type == 'w') {
            // just return back
            // addslashes will destroy the code
            $this->value = addslashes($this->value);
            return (htmlspecialchars($this->value));
        } elseif ($this->type == 'blob') {
            // this is easy for php/mysql developer
            $this->value = addslashes($this->value);
            return (htmlspecialchars($this->value));
        } elseif ($this->type == 'memo' || $this->type == 'm') {
            // this is easy for vb/access developer
            $this->value = addslashes($this->value);
            return (htmlspecialchars($this->value));
        } elseif ($this->type == 'currency') {
            // make easier for vb.net programmer to understand float value
            $this->value = str_replace("$", "", $this->value); // filter for extjs if exist
            $this->value = str_replace(",", "", $this->value);
            return ($this->value);
        } elseif ($this->type == 'float' || $this->type == 'f') {
            // make easier c programmer to understand float value
            $this->value = str_replace("$", "", $this->value); // filter for extjs if exist
            $this->value = str_replace(",", "", $this->value);
            return ($this->value);
        } elseif ($this->type == 'date' || $this->type == 'd') {
            // ext date like this mm/dd yy03/03/07
            // ext date mm/dd/yy mysql date yyyymmdd
            //ext allready validate date at javascript runtime
            // check either the date empty or not if empty key in today value
            if (empty($this->value)) {
                return (date("Y-m-d"));
            } else {
                $day   = substr($this->value, 0, 2);
                $month = substr($this->value, 3, 2);
                $year  = substr($this->value, 6, 4);
                return ($year . "-" . $month . "-" . $day);
            }
        }
    }
}
?>
