<?php

require_once ("../../class/classValidation.php");
/**
 * this is language model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage Language
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LanguageModel extends ValidationClass {
	/**
	 *Language Identification
	 * @var int
	 */
	private $languageId;
	/**
	 * Language Description
	 * @var string
	 */
	private $languageDesc;
	/**
	 * Language Code
	 * @var string
	 */
	private $languageCode;
	/**
	 * Google Api Translation 
	 * @link http://code.google.com/apis/language/
	 * @var string
	 */
	private $isGoogle;
	/**
	 * Bing Api Translation ( Microsoft Product )
	 * @link http://www.microsofttranslator.com/dev/
	 * @var string
	 */
	private $isBing;
	/**
	 * Speak Lite Translation
	 * @link http://www.speaklike.com/
	 * @var string
	 */
	private $isSpeakLite;
	/**
	 * Web Services
	 * @link http://www.webservicex.net/ws/wsdetails.aspx?wsid=63
	 * @var string
	 */
	private $isWebServices;
	
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/**
		 * Basic Information Table
		 */
		$this->setTableName ( 'language' );
		$this->setPrimaryKeyName ( 'languageId' );
		/**
		 * All the $_POST enviroment.
		 */
		if (isset ( $_POST ['languageId'] )) {
			$this->setLanguageId ( $this->strict ( $_POST ['languageId'], 'numeric' ), 0, 'single' );
		}
		if (isset ( $_POST ['languageCode'] )) {
			$this->setLanguageCode ( $this->strict ( $_POST ['languageCode'], 'memo' ) );
		}
		if (isset ( $_POST ['languageDesc'] )) {
			$this->setLanguageDesc ( $this->strict ( $_POST ['languageDesc'], 'memo' ) );
		}
		/**
		 * All the $_POST enviroment.
		 */
		if (isset ( $_GET ['languageId'] )) {
			$this->setTotal ( count ( $_GET ['languageId'] ) );
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
			if (isset ( $_GET ['languageId'] )) {
				$this->setlanguageId ( $this->strict ( $_GET ['languageId'] [$i], 'numeric' ), $i, 'array' );
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
			$primaryKeyAll .= $this->getDefaultLabelId ( $i, 'array' ) . ",";
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
	}
	/**
	 * Set Language   Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLanguageId($value, $key, $type) {
		if ($type == 'single') {
			$this->languageId = $value;
		} else if ($type == 'array') {
			$this->languageId [$key] = $value;
		}
	}
	/**
	 * Return Language Identification Value
	 * Return Module Access Identification
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLanguageId($key, $type) {
		if ($type == 'single') {
			return $this->languageId;
		} else if ($type == 'array') {
			return $this->languageId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type" ) );
			exit ();
		}
	}
	/**
	 * Set Language Description Value
	 * @param  string $value
	 */
	public function setLanguageDesc($value) {
		$this->languageDesc = $value;
	}
	/**
	 * Return Language Description Value
	 * @return string
	 */
	public function getLanguageDesc() {
		return $this->languageDesc;
	}
	/**
	 * Set Language Code Value
	 * @param  string $value
	 */
	public function setLanguageCode($value) {
		$this->languageCode = $value;
	}
	/**
	 * Return Language Value
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}
	/**
	 * @return the $isGoogle
	 */
	public function getIsGoogle() {
		return $this->isGoogle;
	}

	/**
	 * @return the $isBing
	 */
	public function getIsBing() {
		return $this->isBing;
	}

	/**
	 * @return the $isSpeakLite
	 */
	public function getIsSpeakLite() {
		return $this->isSpeakLite;
	}

	/**
	 * @return the $isWebServices
	 */
	public function getIsWebServices() {
		return $this->isWebServices;
	}

	/**
	 * @param string $isGoogle
	 */
	public function setIsGoogle($isGoogle) {
		$this->isGoogle = $isGoogle;
	}

	/**
	 * @param string $isBing
	 */
	public function setIsBing($isBing) {
		$this->isBing = $isBing;
	}

	/**
	 * @param string $isSpeakLite
	 */
	public function setIsSpeakLite($isSpeakLite) {
		$this->isSpeakLite = $isSpeakLite;
	}

	/**
	 * @param string $isWebServices
	 */
	public function setIsWebServices($isWebServices) {
		$this->isWebServices = $isWebServices;
	}

}
?>