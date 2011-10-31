<?php
require_once ("../../class/classValidation.php");
/**
 * this is Document model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Document
 * @subpackage Document
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class DocumentModel extends ValidationClass {
	/**
	 * Document Identification
	 * @var int
	 */
	private $documentId;
	/**
	 * Document Category Identification
	 * @var int
	 */
	private $documentCategoryId;
	/**
	 * Leaf Identification or using default.Leaf identification also will be based on which program installation
	 * @var int
	 */
	private $leafId;
	/**
	 * Document Sequence
	 * @var int
	 */
	private $documentSequence;
	/**
	 * Document Code
	 * @var string
	 */
	private $documentCode;
	/**
	 * Document Note
	 * @var string
	 */
	private $documentNote;
	/**
	 * Document Title.
	 * @var string
	 */
	private $documentTitle;
	/**
	 * Document Description
	 * @var string
	 */
	private $documentDesc;
	/**
	 * Document Path ... Customizeable based on user
	 * @var string
	 */
	private $documentPath;
	/**
	 * Document filename . E.g   financial.xlsx
	 * @var string
	 */
	private $documentOriginalFilename;
	/**
	 * Document filename . E.g   financial.xlsx
	 * @var string
	 */
	private $documentDownloadFilename;
	/**
	 * Document Extension E.g  .pdf  .xlsx
	 * @var string
	 */
	private $documentExtension;
	/**
	 * Document Version
	 * @var int
	 */
	private $documentVersion;
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName ( 'document' );
		$this->setPrimaryKeyName ( 'documentId' );
		/*
		 *  All the $_POST enviroment.
		 */
		if (isset ( $_POST ['documentId'] )) {
			$this->setDocumentId ( $this->strict ( $_POST ['documentId'], 'numeric' ), 0, 'single' );
		}
		if (isset ( $_POST ['documentCategoryId'] )) {
			$this->setDocumentCategoryId ( $this->strict ( $_POST ['documentCategoryId'], 'numeric' ) );
		}
		if (isset ( $_POST ['leafId'] )) {
			$this->setLeafId ( $this->strict ( $_POST ['leafId'], 'numeric' ) );
		}
		if (isset ( $_POST ['documentSequence'] )) {
			$this->setDocumentSequence ( $this->strict ( $_POST ['docuementSequence'], 'numeric' ) );
		}
		if (isset ( $_POST ['documentCode'] )) {
			$this->setDocumentCode ( $this->strict ( $_POST ['documentCode'], 'memo' ) );
		}
		if (isset ( $_POST ['documentNote'] )) {
			$this->setDocumentNote ( $this->strict ( $_POST ['documentNote'], 'memo' ) );
		}
		if (isset ( $_POST ['documentTitle'] )) {
			$this->setDocumentTitle ( $this->strict ( $_POST ['documentTitle'], 'memo' ) );
		}
		if (isset ( $_POST ['documentDesc'] )) {
			$this->setDocumentDesc ( $this->strict ( $_POST ['documentDesc'], 'memo' ) );
		}
		if (isset ( $_POST ['documentPath'] )) {
			$this->setDocumentPath ( $this->strict ( $_POST ['documentPath'], 'memo' ) );
		}
		/**
		* All the $_GET enviroment.
		*/
		if (isset ( $_GET ['documentId'] )) {
			$this->setTotal ( count ( $_GET ['documentId'] ) );
		}
		
		if (isset ( $_GET ['isDefault'] )) {
			if (is_array ( $_GET ['isDefault'] )) {
				$this->isDefault = array ();
			}
		}
		if (isset ( $_GET ['isNew'] )) {
			if (is_array ( $_GET ['isNew'] )) {
				$this->isNew = array ();
			}
		}
		if (isset ( $_GET ['isDraft'] )) {
			if (is_array ( $_GET ['isDraft'] )) {
				$this->isDraft = array ();
			}
		}
		if (isset ( $_GET ['isUpdate'] )) {
			if (is_array ( $_GET ['isUpdate'] )) {
				$this->isUpdate = array ();
			}
		}
		if (isset ( $_GET ['isDelete'] )) {
			if (is_array ( $_GET ['isDelete'] )) {
				$this->isDelete = array ();
			}
		}
		if (isset ( $_GET ['isActive'] )) {
			if (is_array ( $_GET ['isActive'] )) {
				$this->isActive = array ();
			}
		}
		if (isset ( $_GET ['isApproved'] )) {
			if (is_array ( $_GET ['isApproved'] )) {
				$this->isApproved = array ();
			}
		}
		if (isset ( $_GET ['isReview'] )) {
			if (is_array ( $_GET ['isReview'] )) {
				$this->isReview = array ();
			}
		}
		if (isset ( $_GET ['isPost'] )) {
			if (is_array ( $_GET ['isPost'] )) {
				$this->isPost = array ();
			}
		}
		$primaryKeyAll = '';
		for($i = 0; $i < $this->getTotal (); $i ++) {
			if (isset ( $_GET ['documentId'] )) {
				$this->setDocumentId ( $this->strict ( $_GET ['documentId'] [$i], 'numeric' ), $i, 'array' );
			}
			if (isset($_GET ['isDefault'])) {
                if ($_GET ['isDefault'] [$i] == 'true') {
                    $this->setIsDefault(1, $i, 'array');
                } else if ($_GET ['isDefault'] [$i] == 'false') {
                    $this->setIsDefault(0, $i, 'array');
                }
            }
            if (isset($_GET ['isNew'])) {
                if ($_GET ['isNew'] [$i] == 'true') {
                    $this->setIsNew(1, $i, 'array');
                } else if ($_GET ['isNew'] [$i] == 'false') {
                    $this->setIsNew(0, $i, 'array');
                }
            }
            if (isset($_GET ['isDraft'])) {
                if ($_GET ['isDraft'] [$i] == 'true') {
                    $this->setIsDraft(1, $i, 'array');
                } else if ($_GET ['isDraft'] [$i] == 'false') {
                    $this->setIsDraft(0, $i, 'array');
                }
            }
            if (isset($_GET ['isUpdate'])) {
                if ($_GET ['isUpdate'] [$i] == 'true') {
                    $this->setIsUpdate(1, $i, 'array');
                } if ($_GET ['isUpdate'] [$i] == 'false') {
                    $this->setIsUpdate(0, $i, 'array');
                }
            }
            if (isset($_GET ['isDelete'])) {
                if ($_GET ['isDelete'] [$i] == 'true') {
                    $this->setIsDelete(1, $i, 'array');
                } else if ($_GET ['isDelete'] [$i] == 'false') {
                    $this->setIsDelete(0, $i, 'array');
                }
            }
            if (isset($_GET ['isActive'])) {
                if ($_GET ['isActive'] [$i] == 'true') {
                    $this->setIsActive(1, $i, 'array');
                } else if ($_GET ['isActive'] [$i] == 'false') {
                    $this->setIsActive(0, $i, 'array');
                }
            }
            if (isset($_GET ['isApproved'])) {
                if ($_GET ['isApproved'] [$i] == 'true') {
                    $this->setIsApproved(1, $i, 'array');
                } else if ($_GET ['isApproved'] [$i] == 'false') {
                    $this->setIsApproved(0, $i, 'array');
                }
            }
            if (isset($_GET ['isReview'])) {
                if ($_GET ['isReview'] [$i] == 'true') {
                    $this->setIsReview(1, $i, 'array');
                } else if ($_GET ['isReview'] [$i] == 'false') {
                    $this->setIsReview(0, $i, 'array');
                }
            }
            if (isset($_GET ['isPost'])) {
                if ($_GET ['isPost'] [$i] == 'true') {
                    $this->setIsPost(1, $i, 'array');
                } else if ($_GET ['isPost'] [$i] == 'false') {
                    $this->setIsPost(0, $i, 'array');
                }
            }
			$primaryKeyAll .= $this->getDocumentId ( $i, 'array' ) . ",";
		}
		$this->setPrimaryKeyAll ( (substr ( $primaryKeyAll, 0, - 1 )) );
		/**
		 * All the $_SESSION enviroment.
		 */
		if (isset ( $_SESSION ['staffId'] )) {
			$this->setExecuteBy ( $_SESSION ['staffId'] );
		}
		/**
		 * TimeStamp Value.
		 */
		if ($this->getVendor () == self::MYSQL) {
			$this->setExecuteTime ( "'" . date ( "Y-m-d H:i:s" ) . "'" );
		} else if ($this->getVendor () == self::MSSQL) {
			$this->setExecuteTime ( "'" . date ( "Y-m-d H:i:s" ) . "'" );
		} else if ($this->getVendor () == self::ORACLE) {
			$this->setExecuteTime ( "to_date('" . date ( "Y-m-d H:i:s" ) . "','YYYY-MM-DD HH24:MI:SS')" );
		} else {
			echo "udentified vendor ?";
		}
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */
	public function create() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 1, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */
	public function update() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 0, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 1, 0, 'single' );
		$this->setIsActive ( 1, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */
	public function delete() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 0, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 1, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
	public function draft() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 1, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
	public function approved() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 1, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::review()
	*/
	public function review() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
		$this->setIsReview ( 1, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	* @see ValidationClass::post()
	*/
	public function post() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 1, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 1, 0, 'single' );
	}
	/**
	 * Update  Table Status
	 */
	public function updateStatus() {
		if (! (is_array ( $_GET ['isDefault'] ))) {
			$this->setIsDefault ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isNew'] ))) {
			$this->setIsNew ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isDraft'] ))) {
			$this->setIsDraft ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isUpdate'] ))) {
			$this->setIsUpdate ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isDelete'] ))) {
			$this->setIsDelete ( 1, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isActive'] ))) {
			$this->setIsActive ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isApproved'] ))) {
			$this->setIsApproved ( 0, 0, 'single' );
		}
	}
	/**
	 * Set isDefault Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setDocumentId($value, $key, $type) {
		if ($type == 'single') {
			$this->documentId = $value;
		} else if ($type == 'array') {
			$this->documentId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:setDocumentId ?" ) );
			exit ();
		}
	}
	/**
	 * Return Document Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getDocumentId($key, $type) {
		if ($type == 'single') {
			return $this->documentId;
		} else if ($type == 'array') {
			return $this->documentId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:getDocumentId ?" ) );
			exit ();
		}
	}
	/**
	 * Set Document Category Identification Value
	 * @param  int $value
	 */
	public function setDocumentCategoryId($value) {
		$this->documentCategoryId = $value;
	}
	/**
	 * Return Document Category Identification Value
	 * @return int
	 */
	public function getDocumentCategoryId() {
		return $this->documentCategoryId;
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int
	 */
	public function getLeafId() {
		return $this->leafId;
	}
	/**
	 * Set Document Sequence Number Value
	 * @param  int $value
	 */
	public function setDocumentSequence($value) {
		$this->documentSequence = $value;
	}
	/**
	 * Return Document Sequence Number
	 * @return int
	 */
	public function getDocumentSequence() {
		return $this->documentSequence;
	}
	/**
	 * Set Document Code Value
	 * @param string $value
	 */
	public function setDocumentCode($value) {
		$this->documentCode = $value;
	}
	/**
	 * Return Document Code
	 * @return string
	 */
	public function getDocumentCode() {
		return $this->documentCode;
	}
	/**
	 * Set Document Note Value
	 * @param string $value
	 */
	public function setDocumentNote($value) {
		$this->documentNote = $value;
	}
	/**
	 * Return Document Note
	 * @return string
	 */
	public function getDocumentNote() {
		return $this->documentNote;
	}
	/**
	 * Set Document Title Value
	 * @param string $value
	 */
	public function setDocumentTitle($value) {
		$this->documentTitle = $value;
	}
	/**
	 * Return Document title
	 * @return string
	 */
	public function getDocumentTitle() {
		return $this->documentTitle;
	}
	/**
	 * Set Document Description Value
	 * @param string $value
	 */
	public function setDocumentDesc($value) {
		$this->documentTitle = $value;
	}
	/**
	 * Return Document Description
	 * @return string
	 */
	public function getDocumentDesc() {
		return $this->documentDesc;
	}
	/**
	 * Set Document Path Value
	 * @param string $value
	 */
	public function setDocumentPath($value) {
		$this->documentPath = $value;
	}
	/**
	 * Return Document title
	 * @return string
	 */
	public function getDocumentPath() {
		return $this->documentPath;
	}
	/**
	 * Set Document Original Filename Value
	 * @param string $value
	 */
	public function setDocumentOriginalFilename($value) {
		$this->documentOriginalFilename = $value;
	}
	/**
	 * Return Document Original Filename
	 * @return stringa
	 */
	public function getDocumentOriginalFilename() {
		return $this->documentOriginalFilename;
	}
	/**
	 * Set Document Download Filename Value
	 * @param string $value
	 */
	public function setDocumentDownloadFilename($value) {
		$this->documentDownloadFilename = $value;
	}
	/**
	 * Return Document Download Filename
	 * @return string
	 */
	public function getDocumentDownloadFilename() {
		return $this->documentDownloadFilename;
	}
	/**
	 * Set Document Extension Value
	 * @param string $value
	 */
	public function setDocumentExtension($value) {
		$this->documentExtension = $value;
	}
	/**
	 * Return Document Extension
	 * @return string
	 */
	public function getDocumentExtension() {
		return $this->documentExtension;
	}
	/**
	 * Set Document Version Value
	 * @param int $value
	 */
	public function setDocumentVersion($value) {
		$this->documentVersion = $value;
	}
	/**
	 * Return Document Version
	 * @return int
	 */
	public function getDocumentVersion() {
		return $this->documentVersion;
	}
}
?>
