<script type="text/javascript">
<?php
if ($q->vendor == sharedx::MYSQL) {
	/*     * *
     * set global output UTF8
     */
	$sql = "SET NAMES \"utf8\"";
	$q->fast ( $sql );
}

/**
 * all label language
 * */
if ($q->vendor == sharedx::MYSQL) {
	// future
	$sql = "
                SELECT 			`tableMapping`.`tableMappingColumnName`,
                                 `tableMappingTranslate`.`tableMappingNativeLabel`
                FROM 			`tableMapping`
                JOIN			`tableMappingTranslate`
                USING			(`tableMappingId`)
                WHERE 			`tableMappingTranslate`.`languageId`='" . $_SESSION ['languageId'] . "'";
	// temp
	$sql = "
                SELECT 			`tableMapping`.`tableMappingColumnName`,
                                `tableMapping`.`tableMappingNativeLabel`
                FROM 			`tableMapping`
                WHERE 			`tableMapping`.`languageId`='" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor == sharedx::MSSQL) {
	$sql = "
                SELECT 			[tableMapping].[tableMappingColumnName],
                                [tableMappingTranslate].[tableMappingNativeLabel]
                FROM 			[tableMapping]
                JOIN			[tableMappingTranslate]
                USING			[tableMapping].[tableMappingId]=[tableMappingTranslate].[tableMappingId]
                WHERE 			[tableMapping].[languageId]='" . $_SESSION ['languageId'] . "'";
	// temp
	$sql = "
                SELECT 			[tableMapping].[tableMappingColumnName],
                                                [tableMapping].[tableMappingNativeLabel]
                FROM 			[tableMapping]
                WHERE 			[tableMapping].[languageId]='" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor == sharedx::ORACLE) {
	$sql = "
                SELECT DISTINCT TABLEMAPPING.TABLEMAPPINGCOLUMNNAME 			AS 	\"tableMappingColumnName\",
                                TABLEMAPPINGTRANSLATE.TABLEMAPPINGNATIVELABEL	AS	\"tableMappingNativeLabel\"
                FROM 			TABLEMAPPING
                JOIN			TABLEMAPPINGTRANSLATE
                USING			(TABLEMAPPINGID)
                WHERE 			TABLEMAPPING.LANGUAGEID='" . $_SESSION ['languageId'] . "'";
	// temp
	$sql = "
                SELECT 			TABLEMAPPING.TABLEMAPPINGCOLUMNNAME AS  \"tableMappingColumnName\",
                                TABLEMAPPING.TABLEMAPPINGNATIVELABEL AS \"tableMappingNativeLabel\"
                FROM 			TABLEMAPPING
                WHERE 			TABLEMAPPING.LANGUAGEID='" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor ==sharedx::DB2) {
} else if ($q->vendor ==sharedx::POSTGRESS) {
}	

$result = $q->fast ( $sql );

while ( ($row = $q->fetchAssoc ( $result )) == TRUE ) {
	echo "var " . $row ['tableMappingColumnName'] . "Label = '" . $row ['tableMappingNativeLabel'] . "';\n";
}
/**
 * language pack javascript default
 * */
if ($q->vendor == sharedx::MYSQL) {
	$sql = "
                SELECT	*
                FROM 	`defaultLabel`
                JOIN 	`defaultLabelTranslate`
                USING 	(`defaultLabelId`)
                WHERE 	`defaultLabelTranslate`.`languageId`	=	'" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor == sharedx::MSSQL) {
	$sql = "
                SELECT	*
                FROM 	[defaultLabel]
                JOIN 	[defaultLabelTranslate]
                ON		[defaultLabel] .[defaultLabelId]=  [defaultLabelTranslate] .[defaultLabelId]
                WHERE 	[defaultLabelTranslate].[languageId]	=	'" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor == sharedx::ORACLE) {
	$sql = "
                SELECT	DEFAULTLABEL.DEFAULTLABEL 				AS \"defaultLabel\",
                        DEFAULTLABELTRANSLATE.DEFAULTLABELTEXT 	AS \"defaultLabelText\"
                FROM 	DEFAULTLABEL
                JOIN 	DEFAULTLABELTRANSLATE
                ON		DEFAULTLABEL.DEFAULTLABELID 			= 	DEFAULTLABELTRANSLATE.DEFAULTLABELID
                WHERE 	DEFAULTLABELTRANSLATE.LANGUAGEID		=	'" . $_SESSION ['languageId'] . "'";
}else if ($q->vendor ==sharedx::DB2) {
} else if ($q->vendor ==sharedx::POSTGRESS) {
}	
$result = $q->fast ( $sql );
while ( $row = $q->fetchAssoc ( $result ) ) {
	echo "var " . $row ['defaultLabel'] . " = '" . $row ['defaultLabelText'] . "';\n";
}

/**
 * static variable
 * */
$staffId = 'staffId';
$phpself = 'PHP_SELF';

echo "var filename = '" . basename ( $_SERVER ['PHP_SELF'] ) . "';";

if ($q->vendor == sharedx::MYSQL) {
		$sql = "	SELECT	*
        FROM	`leaf`
        JOIN	`leafAccess`
        USING 	(`leafId`)
        JOIN 	`leafTranslate`
        USING	(`leafId`)
        WHERE  	`leaf`.`leafFilename`			=	'" . basename ( $_SERVER ['PHP_SELF'] ) . "'
        AND  	`leafAccess`.`staffId`			=	'" . $_SESSION ['staffId'] . "'
        AND		`leafTranslate`.`languageId`	=	'" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor == sharedx::MSSQL) {
	$sql = "	
        SELECT	*
        FROM	[leaf]
        JOIN	[leafAccess]
        ON 		[leaf].[leafId]					= 	[leafAccess].[leafId]
        JOIN 	[leafTranslate]
        ON		[leafAccess].[leafId]			=	[leafTranslate].[leafId]
        AND 	[leafTranslate].[leafId]		= 	[leaf].[leafId]
        WHERE  	[leaf].[leafFilename]			=	'" . basename ( $_SERVER ['PHP_SELF'] ) . "'
        AND  	[leafAccess].[staffId]			=	'" . $_SESSION ['staffId'] . "'
        AND		[leafTranslate].[languageId]	=	'" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor == sharedx::ORACLE) {
	
	$sql = "	SELECT	LEAF.LEAFID 						AS  \"leafId\",
                        LEAFTRANSLATE.LEAFTRANSLATE 		AS	\"leafNote\",
                        LEAFACCESS.LEAFACCESSCREATEVALUE 	AS 	\"leafAccessCreateValue\",
                        LEAFACCESS.LEAFACCESSREADVALUE		AS  \"leafAccessReadValue\",
                        LEAFACCESS.LEAFACCESSPRINTVALUE 	AS 	\"leafAccessPrintValue\"
        FROM	LEAF
        JOIN	LEAFACCESS
        ON		LEAF.LEAFID 				= 	LEAFACCESS.LEAFID
        JOIN 	LEAFTRANSLATE
        ON		LEAF.LEAFID 				= 	LEAFTRANSLATE.LEAFID
        WHERE  	LEAF.LEAFFILENAME			=	'" . basename ( $_SERVER ['PHP_SELF'] ) . "'
        AND  	LEAFACCESS.STAFFID			=	'" . $_SESSION ['staffId'] . "'
        AND		LEAFTRANSLATE.LANGUAGEID	=	'" . $_SESSION ['languageId'] . "'";
} else if ($q->vendor ==sharedx::DB2) {
} else if ($q->vendor ==sharedx::POSTGRESS) {
}		

$result = $q->fast ( $sql );

$row_leafAccess = $q->fetchAssoc ( $result );
?>

    var leafId					= '<?php echo $row_leafAccess['leafId']; ?>';
    var leafNote				= '<?php echo $row_leafAccess['leafTranslate']; ?>';
    var leafAccessCreateValue	= '<?php echo $row_leafAccess['leafAccessCreateValue']; ?>';
    var leafAccessReadValue		= '<?php echo $row_leafAccess['leafAccessReadValue']; ?>';
    var leafAccessPrintValue	= '<?php echo $row_leafAccess['leafAccessPrintValue']; ?>';
    var leafAccessPostValue		= '<?php echo $row_leafAccess['leafAccessPostValue']; ?>';
<?php
if ($q->vendor == sharedx::MYSQL) {
	$sql = "
                        SELECT	`team`.`isAdmin`
                        FROM 	`staff`
                        JOIN	`team`
                        USING	(`teamId`)
                        WHERE 	`staff`.`staffId`	=	'" . $_SESSION ['staffId'] . "'
                        AND		`team`.`teamId`	=	'" . $_SESSION ['teamId'] . "'
                        AND		`staff`.`isActive`	=	1
                        AND		`team`.`isActive`	=	1";
} else if ($q->vendor == sharedx::MSSQL) {
	$sql = "
                        SELECT	[team].[isAdmin]
                        FROM 	[staff]
                        JOIN	[team]
                        ON		[staff].[teamId]  	= 	[team].[teamId]
                        WHERE 	[staff].[staffId]	=	'" . $_SESSION ['staffId'] . "'
                        AND		[team].[teamId]	=	'" . $_SESSION ['teamId'] . "'
                        AND		[staff].[isActive]	=	1
                        AND		[team].[isActive]	=	1";
} else if ($q->vendor == sharedx::ORACLE) {
	$sql = "
                        SELECT	TEAM.ISADMIN AS \"isAdmin\"
                        FROM 	STAFF
                        JOIN	TEAM
                        ON		TEAM.TEAMID	= 	STAFF.TEAMID
                        WHERE 	STAFF.STAFFID	=	'" . $_SESSION ['staffId'] . "'
                        AND		TEAM.TEAMID	=	'" . $_SESSION ['TEAMID'] . "'
                        AND		STAFF.ISACTIVE	=	1
                        AND		TEAM.ISACTIVE	=	1";
} else if ($q->vendor ==sharedx::DB2) {
} else if ($q->vendor ==sharedx::POSTGRESS) {
}	else {
	echo json_encode ( array ("success" => false, "message" => "cannot identify vendor db[" . $q->vendor . "]" ) );
	exit ();
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
        isPostHidden    = false;
        auditButtonLabelDisabled = false;
        
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
        auditButtonLabelDisabled = true;
    }
    var isDefaultLabel		= 'Default Value';
    var isNewLabel	 		= 'New';
    var isDraftLabel 		= 'Draft';
    var isUpdateLabel		= 'Update';
    var isDeleteLabel		= 'Delete';
    var isActive 			= 'Active';
    var isApprovedLabel		= 'Approved';
	var auditButtonLabel 	= 'Audit';
</script>
