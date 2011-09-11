<script type="text/javascript">
<?php
if ($q->vendor == sharedx::mysql) {
    /*     * *
     * set global output UTF8
     */
    $sql = "SET NAMES \"utf8\"";
    $q->fast($sql);
}

/**
 * 	 all label language
 * */
if ($q->vendor == sharedx::mysql) {
    // future
    $sql = "
                SELECT 			`tableMapping`.`tableMappingColumnName`,
                                                `tableMappingTranslate`.`tableMappingNativeLabel`
                FROM 			`tableMapping`
                JOIN			`tableMappingTranslate`
                USING			(`tableMappingId`)
                WHERE 			`tableMappingTranslate`.`languageId`=\"" . $_SESSION['languageId'] . "\"";
    // temp
    $sql = "
                SELECT 			`tableMapping`.`tableMappingColumnName`,
                                                `tableMapping`.`tableMappingNativeLabel`
                FROM 			`tableMapping`
                WHERE 			`tableMapping`.`languageId`=\"" . $_SESSION['languageId'] . "\"";
} else if ($q->vendor == sharedx::mssql) {
    $sql = "
                SELECT 			[tableMapping].[tableMappingColumnName],
                                [tableMappingTranslate].[tableMappingNativeLabel]
                FROM 			[tableMapping]
                JOIN			[tableMappingTranslate]
                USING			[tableMapping].[tableMappingId]=[tableMappingTranslate].[tableMappingId]
                WHERE 			[tableMapping].[languageId]='" . $_SESSION['languageId'] . "'";
    // temp
    $sql = "
                SELECT 			[tableMapping].[tableMappingColumnName],
                                                [tableMapping].[tableMappingNativeLabel]
                FROM 			[tableMapping]
                WHERE 			[tableMapping].[languageId]='" . $_SESSION['languageId'] . "'";
} else if ($q->vendor == sharedx::oracle) {
    $sql = "
                SELECT DISTINCT \"tableMapping\".\"tableMappingColumnName\",
                                                \"tableMappingTranslate\".\"tableMappingNativeLabel\"
                FROM 			\"tableMapping\"
                JOIN			\"tableMappingTranslate\"
                USING			(\"tableMappingId\")
                WHERE 			\"tableMapping\".LANGUAGEID=\"" . $_SESSION['languageId'] . "\"";
    // temp
    $sql = "
                SELECT 			TABLEMAPPING.TABLEMAPPINGCOLUMNNAME AS  \"tableMappingColumnName\",
                                TABLEMAPPING.TABLEMAPPINGNATIVELABEL AS \"tableMappingNativeLabel\"
                FROM 			TABLEMAPPING
                WHERE 			TABLEMAPPING.LANGUAGEID='" . $_SESSION['languageId'] . "'";
} else {
    
}

$result = $q->fast($sql);

while ($row = $q->fetchAssoc($result)) {
    echo "var " . $row['tableMappingColumnName'] . "Label = \"" . $row['tableMappingNativeLabel'] . "\";\n";
}
/**
 * 	language pack javascript default
 * */
if ($q->vendor == sharedx::mysql
) {
    $sql = "
                SELECT	*
                FROM 	`defaultLabel`
                JOIN 	`defaultLabelTranslate`
                USING 	(`defaultLabelId`)
                WHERE 	`defaultLabelTranslate`.`languageId`	=	\"" . $_SESSION['languageId'] . "\"";
} else if ($q->vendor == sharedx::mssql) {
    $sql = "
                SELECT	*
                FROM 	[defaultLabel]
                JOIN 	[defaultLabelTranslate]
                ON		[defaultLabel] .[defaultLabelId]=  [defaultLabelTranslate] .[defaultLabelId]
                WHERE 	[defaultLabelTranslate].[languageId]	=	'" . $_SESSION['languageId'] . "'";
} else if ($q->vendor == sharedx::oracle) {
     $sql = "
                SELECT	DEFAULTLABEL.DEFAULTLABEL 				AS \"defaultLabel\",
                                DEFAULTLABELTRANSLATE.DEFAULTLABELTEXT 	AS \"defaultLabelText\"
                FROM 	DEFAULTLABEL
                JOIN 	DEFAULTLABELTRANSLATE
                ON		DEFAULTLABEL.DEFAULTLABELID 			= 	DEFAULTLABELTRANSLATE.DEFAULTLABELID
                WHERE 	DEFAULTLABELTRANSLATE.LANGUAGEID		=	'" . $_SESSION['languageId'] . "'";
}
$result = $q->fast($sql);
while ($row = $q->fetchAssoc($result)) {
    echo "var " . $row['defaultLabel'] . " = \"" . $row['defaultLabelText'] . "\";\n";
}

/**
 * 	 static variable
 * */
$staffId = 'staffId';
$phpself = 'PHP_SELF';

echo "var filename = '" . basename($_SERVER[$phpself]) . "';";


if ($q->vendor == sharedx::mysql) {
    $sql =
            "	SELECT	*
        FROM	`leaf`
        JOIN	`leafAccess`
        USING 	(`leafId`)
        JOIN 	`leafTranslate`
        USING	(`leafId`)
        WHERE  	`leaf`.`leafFilename`			=	\"" . basename($_SERVER[$phpself]) . "\"
        AND  	`leafAccess`.`staffId`			=	\"" . $_SESSION[$staffId] . "\"
        AND		`leafTranslate`.`languageId`	=	\"" . $_SESSION['languageId'] . "\"";
} else if ($q->vendor == sharedx::mssql) {
    $sql =
            "	SELECT	*
        FROM	[leaf]
        JOIN	[leafAccess]
        ON 		[leaf].[leafId]= 	[leafAccess].[leafId]
        JOIN 	[leafTranslate]
        ON		[leafAccess].[leafId]	=[leafTranslate].[leafId]
        AND 	[leafTranslate].[leafId]= [leaf].[leafId]
        WHERE  	[leaf].[leafFilename]			=	'" . basename($_SERVER[$phpself]) . "'
        AND  	[leafAccess].[staffId]			=	'" . $_SESSION[$staffId] . "'
        AND		[leafTranslate].[languageId]	=	'" . $_SESSION['languageId'] . "'";
} else if ($q->vendor == sharedx::oracle) {

   $sql =
            "	SELECT	LEAF.LEAFID 						AS  \"leafId\",
                        LEAFTRANSLATE.LEAFTRANSLATE 		AS	\"leafNote\",
                        LEAFACCESS.LEAFCREATEACCESSVALUE 	AS 	\"leafCreateAccessValue\",
                        LEAFACCESS.LEAFREADACCESSVALUE 		AS  \"leafReadAccessValue\",
                        LEAFACCESS.LEAFPRINTACCESSVALUE 	AS 	\"leafPrintAccessValue\"
        FROM	LEAF
        JOIN	LEAFACCESS
        ON		LEAF.LEAFID 				= 	LEAFACCESS.LEAFID
        JOIN 	LEAFTRANSLATE
        ON		LEAF.LEAFID 				= 	LEAFTRANSLATE.LEAFID
        WHERE  	LEAF.LEAFFILENAME			=	'" . basename($_SERVER[$phpself]) . "'
        AND  	LEAFACCESS.STAFFID			=	'" . $_SESSION[$staffId] . "'
        AND		LEAFTRANSLATE.LANGUAGEID	=	'" . $_SESSION['languageId'] . "'";
}

$result = $q->fast($sql);

$row_leafAccess = $q->fetchAssoc($result);
?>

    var leafId			= '<?php echo $row_leafAccess['leafId']; ?>';
    var leafNote			= '<?php echo $row_leafAccess['leafTranslate']; ?>';
    var leafCreateAccessValue	= '<?php echo $row_leafAccess['leafCreateAccessValue']; ?>';
    var leafReadAccessValue		= '<?php echo $row_leafAccess['leafReadAccessValue']; ?>';
    var leafPrintAccessValue	= '<?php echo $row_leafAccess['leafPrintAccessValue']; ?>';

<?php
if ($q->vendor == sharedx::mysql) {
    $sql = "
                        SELECT	`group`.`isAdmin`
                        FROM 	`staff`
                        JOIN	`group`
                        USING	(`groupId`)
                        WHERE 	`staff`.`staffId`	=	\"" . $_SESSION['staffId'] . "\"
                        AND		`group`.`groupId`	=	\"" . $_SESSION['groupId'] . "\"
                        AND		`staff`.`isActive`	=	1
                        AND		`group`.`isActive`	=	1";
} else if ($q->vendor == sharedx::mssql) {
    $sql = "
                        SELECT	[group].[isAdmin]
                        FROM 	[staff]
                        JOIN	[group]
                        ON		[staff].[groupId]  	= 	[group].[groupId]
                        WHERE 	[staff].[staffId]	=	'" . $_SESSION['staffId'] . "'
                        AND		[group].[groupId]	=	'" . $_SESSION['groupId'] . "'
                        AND		[staff].[isActive]	=	1
                        AND		[group].[isActive]	=	1";
} else if ($q->vendor == sharedx::oracle) {
   $sql = "
                        SELECT	GROUP_.ISADMIN AS \"isAdmin\"
                        FROM 	STAFF
                        JOIN	GROUP_
                        ON		GROUP_.GROUPID	= 	STAFF.GROUPID
                        WHERE 	STAFF.STAFFID	=	'" . $_SESSION['staffId'] . "'
                        AND		GROUP_.GROUPID	=	'" . $_SESSION['groupId'] . "'
                        AND		STAFF.ISACTIVE	=	1
                        AND		GROUP_.ISACTIVE	=	1";
} else {
    echo json_encode(array("success" => false, "message" => "cannot identify vendor db[" . $q->vendor . "]"));
    exit();
}

//echo $sql;
$resultAdmin = $q->fast($sql);

if ($q->numberRows($resultAdmin) > 0) {

    $rowAdmin = $q->fetchAssoc($resultAdmin);
}
?>
    var isAdmin = <?php echo $rowAdmin['isAdmin']; ?>;
    if (isAdmin  == 1 ) {
        isDefaultHidden 	= false;
        isNewHidden   		= false;
        isDraftHidden 		= false;
        isUpdateHidden  	= false;
        isDeleteHidden      = false;
        isActiveHidden		= false;
        isApprovedHidden	= false;
    } else {
        isDefaultHidden 	= true;
        isNewHidden   		= true;
        isDraftHidden 		= true;
        isUpdateHidden  	= true;
        isDeleteHidden      = true;
        isActiveHidden		= true;
        isApprovedHidden	= true;
    }
    var isDefaultLabel		= 'Default Value';
    var isNewLabel	 		= 'New';
    var isDraftLabel 		= 'Draft';
    var isUpdateLabel		= 'Update';
    var isDeleteLabel		= 'Delete';
    var isActive 			= 'Active';
    var isApprovedLabel		= 'Approved';

</script>
