<script type="text/javascript">
<?php

		if($q->vendor=='mysql') {
			/**
			*
			* set global output UTF8
			*/
			$sql="SET NAMES \"utf8\"";
			$q->fast($sql);
		}

	/**
 * all label language
 * */
if ($q->vendor == sharedx::MYSQL) {
	// future
	$sql = "
                SELECT 			`tableMapping`.`tableMappingColumnName`,
                                 `tableMappingTranslate`.`tableMappingNative`
                FROM 			`tableMapping`
                JOIN			`tableMappingTranslate`
                USING			(`tableMappingId`)
                WHERE 			`tableMappingTranslate`.`languageId`='" . $_SESSION ['languageId'] . "'";
	
} else if ($q->vendor == sharedx::MSSQL) {
	$sql = "
                SELECT 			[tableMapping].[tableMappingColumnName],
                                [tableMappingTranslate].[tableMappingNative]
                FROM 			[tableMapping]
                JOIN			[tableMappingTranslate]
                USING			[tableMapping].[tableMappingId]=[tableMappingTranslate].[tableMappingId]
                WHERE 			[tableMapping].[languageId]='" . $_SESSION ['languageId'] . "'";
	
} else if ($q->vendor == sharedx::ORACLE) {
	$sql = "
                SELECT DISTINCT TABLEMAPPING.TABLEMAPPINGCOLUMNNAME 			AS 	\"tableMappingColumnName\",
                                TABLEMAPPINGTRANSLATE.TABLEMAPPINGNATIVELABEL	AS	\"tableMappingNative\"
                FROM 			TABLEMAPPING
                JOIN			TABLEMAPPINGTRANSLATE
                USING			(TABLEMAPPINGID)
                WHERE 			TABLEMAPPING.LANGUAGEID='" . $_SESSION ['languageId'] . "'";
	
} else if ($q->vendor ==sharedx::DB2) {
} else if ($q->vendor ==sharedx::POSTGRESS) {
}	
	$result	=	$q->fast($sql);

while (($row = $q->fetchAssoc($result))== TRUE)  {

		echo "var ".$row['tableMappingColumnName']."Label = '".$row['tableMappingNative']."';\n";
	   } 

/**
*
*	language pack javascript default
*/
	if($q->vendor==sharedx::MYSQL) {
	$sql="
	SELECT	*
	FROM 	`defaultLabel`
	JOIN 	`defaultLabelTranslate`
	USING 	(`defaultLabelId`)
	WHERE 	`defaultLabelTranslate`.`languageId`='".$_SESSION['languageId']."'";
	} else if ($q->vendor==sharedx::MSSQL) {
			$sql="
			SELECT	*
			FROM 	[defaultLabel]
			JOIN 	[defaultLabelTranslate]
			ON		[defaultLabel] .[defaultLabelId]		=  	[defaultLabelTranslate] .[defaultLabelId]
			WHERE 	[defaultLabelTranslate].[languageId]	=	'".$_SESSION['languageId']."'";
	} else if ($q->vendor==sharedx::ORACLE) {
	$sql="
			SELECT	DEFAULTLABEL.DEFAULTLABEL 				AS  \"defaultLabel\"
					DEFAULTLABELTRANSLATE.DEFAULTLABELTEXT 	AS 	\"defaultLabelText\"
			FROM 	DEFAULTLABEL
			JOIN 	DEFAULTLABELTRANSLATE
			ON		DEFAULTLABEL .DEFAULTLABELID		=  DEFAULTLABELTRANSLATE .DEFAULTLABELID
			WHERE 	DEFAULTLABELTRANSLATE.LANGUAGEID	=	'".$_SESSION['languageId']."'";
	}
	$result	=	$q->fast($sql);
	while (($row = $q->fetchAssoc($result))==TRUE) {



		echo "var ".$row['defaultLabel']." = '".$row['defaultLabel']."';\n";
	  }

/**
*
*	 static variable
*/
$staffId='staffId';
$phpself='PHP_SELF';
?>
var filename = '<?php echo basename($_SERVER[$phpself]); ?>';
<?php  // get uniqueid

if($q->vendor==sharedx::MYSQL) {
 	$sql	=
"	SELECT	*
	FROM	`leaf`
	JOIN	`leafAccess`
	USING 	(`leafId`)
	JOIN 	`leafTranslate`
	USING	(`leafId`)
	WHERE  	`leaf`.`leafFilename`			=	'".basename($_SERVER[$phpself])."'
	AND  	`leafAccess`.`staffId`			=	'".$_SESSION[$staffId]."'
	AND		`leafTranslate`.`languageId`	=	'".$_SESSION['languageId']."'";
	} else if ($q->vendor==sharedx::MSSQL) {
	$sql	=
"	SELECT	*
	FROM	[leaf]
	JOIN	[leafAccess]
	ON 		[leaf].[leafId]					= 	[leafAccess].[leafId]
	JOIN 	[leafTranslate]
	ON		[leafAccess].[leafId]			=	[leafTranslate].[leafId]
	AND 	[leafTranslate].[leafId]		= 	[leaf].[leafId]
	WHERE  	[leaf].[leafFilename]			=	'".basename($_SERVER[$phpself])."'
	AND  	[leafAccess].[staffId]			=	'".$_SESSION[$staffId]."'
	AND		[leafTranslate].[languageId]	=	'".$_SESSION['languageId']."'";
	} else if ($q->vendor==sharedx::ORACLE) {

	$sql	=
"	SELECT	LEAF.LEAFID 				 		AS	\"leafId\",
			LEAFTRANSLATE.LEAFTRANSLATE	 		AS	\"leafTranslate\",
			LEAFACCESS.leafAccessCreateValue 	AS	\"leafAccessCreateValue\",
			LEAFACCESS.leafAccessReadValue 		AS	\"leafAccessReadValue\",
			LEAFACCESS.leafAccessPrintValue 	AS	\"leafAccessPrintValue\"
	FROM	LEAF
	JOIN	LEAFACCESS
	ON 		LEAF.LEAFID					= 	LEAFACCESS.LEAFID
	JOIN 	LEAFTRANSLATE
	ON		LEAFACCESS.LEAFID			=	LEAFTRANSLATE.LEAFID
	AND 	LEAFTRANSLATE.LEAFID		= 	LEAF.LEAFID
	WHERE  	LEAF.LEAFFILENAME			=	'".basename($_SERVER[$phpself])."'
	AND  	LEAFACCESS.STAFFID			=	'".$_SESSION[$staffId]."'
	AND		LEAFTRANSLATE.LANGUAGEID	=	'".$_SESSION['languageId']."'";
	}

$result	=	$q->fast($sql);

$row_leafAccess 		= 	$q->fetchAssoc($result);

?>

var leafIdTemp				= '<?php echo $row_leafAccess['leafId'];   ?>';
var leafNative				= '<?php echo $row_leafAccess['leafNative'];   ?>';
var leafAccessCreateValue	= '<?php echo $row_leafAccess['leafAccessCreateValue'];   ?>';
var leafAccessReadValue		= '<?php echo $row_leafAccess['leafAccessReadValue'];   ?>';
var leafAccessPrintValue	= '<?php echo $row_leafAccess['leafAccessPrintValue'];   ?>';
var leafAccessPostValue	= '<?php echo $row_leafAccess['leafAccessPostValue']; ?>';



<?php
		if( $q->vendor==sharedx::MYSQL) {
			$sql	=	"
			SELECT	`team`.`isAdmin`
			FROM 	`staff`
			JOIN	`team`
			USING	(`teamId`)
			WHERE 	`staff`.`staffId`	=	'".$_SESSION['staffId']."'
			AND		`team`.`teamId`	=	'".$_SESSION['teamId']."'";
		} else if ($q->vendor==sharedx::MSSQL) {
			$sql	=	"
			SELECT	[team].[isAdmin]
			FROM 	[staff]
			JOIN	[team]
			ON		[staff].[teamId]  	= 	[team].[teamId]
			WHERE 	[staff].[staffId]	=	'".$_SESSION['staffId']."'
			AND		[team].[teamId]	=	'".$_SESSION['teamId']."'";
		} else if ($q->vendor==sharedx::ORACLE) {
			$sql	=	"
			SELECT	TEAM.ISADMIN AS \"isAdmin\"
			FROM 	STAFF
			JOIN	TEAM
			USING   (TEAMID)
			WHERE 	STAFF.STAFFID	=	'".$_SESSION['staffId']."'
			AND		TEAM.TEAMID	=	'".$_SESSION['teamId']."'";
		} else {
			echo json_encode(array("success"=>false,"message"=>"cannot identify vendor db[".$q->vendor."]"));
			exit();
		}

		//echo $sql;
		$resultAdmin = $q->fast ( $sql );
		
		if ($q->numberRows ( $resultAdmin ) > 0) {
			$rowAdmin = $q->fetchAssoc ( $resultAdmin );
			?>
		var isAdmin = <?php echo $rowAdmin['isAdmin']; ?>;
		
		<?php } else { 
		?>
		var isAdmin;
		<?php } ?>
if (isAdmin  == 1 ) {
	isDefaultHidden 	= false;
	isNewHidden   		= false;
	isDraftHidden 		= false;
	isUpdateHidden  	= false;
	isDeleteHidden      = false;
	isActiveHidden		= false;
	isApprovedHidden	= false;
	isReviewHidden		= false;
    isPostHidden    	= false;
} else {
	isDefaultHidden 	= true;
	isNewHidden   		= true;
	isDraftHidden 		= true;
	isUpdateHidden  	= true;
	isDeleteHidden      = true;
	isActiveHidden		= true;
	isApprovedHidden	= true;
	isReviewHidden		= true;
    isPostHidden    	= true;
}
var isDefaultLabel		= 'Default Value';
var isNewLabel	 		= 'New';
var isDraftLabel 		= 'Draft';
var isUpdateLabel		= 'Update';
var isDeleteLabel		= 'Delete';
var isActiveLabel 		= 'Active';
var isReviewLabel		= 'Review';
var isApprovedLabel		= 'Approved';

</script>
