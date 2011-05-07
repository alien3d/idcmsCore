<script language="javascript" type="text/javascript">
<?php

		if($q->vendor=='normal' || $q->vendor=='mysql') {
			/***
			* set global output UTF8
			*/
			$sql='SET NAMES "utf8"';
			$q->fast($sql);
		}

	/**
	*	 all label language
	**/
	if($q->vendor=='normal' || $q->vendor=='mysql') {
		$sql="
		SELECT DISTINCT `tableMappingColumnName`,
						`tableMappingNativeLabel`
		FROM 			`tableMapping`
		WHERE 			`tableMapping`.`languageId`='".$_SESSION['languageId']."'";
	} else if ($q->vendor=='microsoft') {
		$sql="
		SELECT DISTINCT [tableMappingColumnName],
						[tableMappingNativeLabel]
		FROM 			[tableMapping]
		WHERE 			[tableMapping].[languageId]='".$_SESSION['languageId']."'";
	} else if ($q->vendor=='oracle') {
		$sql="
		SELECT DISTINCT \"tableMappingColumnName\",
						\"tableMappingNativeLabel\"
		FROM 			\"tableMapping\"
		WHERE 			\"tableMapping\".\"languageId\"='".$_SESSION['languageId']."'";
	} else {

	}
	$result	=	$q->fast($sql);

while ($row = $q->fetchAssoc($result)) {

		echo "var ".$row['tableMappingColumnName']."Label = '".$row['tableMappingNativeLabel']."';\n";
	   } ?>
<?php
/**
*	language pack javascript default
**/
	if($q->vendor=='normal' || $q->vendor=='mysql') {
	$sql="
	SELECT	*
	FROM 	`defaultLabel`
	JOIN 	`defaultLabelTranslate`
	USING 	(`defaultLabelId`)
	WHERE 	`defaultLabelTranslate`.`languageId`='".$_SESSION['languageId']."'";
	} else if ($q->vendor=='microsoft') {
			$sql="
			SELECT	*
			FROM 	[defaultLabel]
			JOIN 	[defaultLabelTranslate]
			ON		[defaultLabel] .[defaultLabelId]=  [defaultLabelTranslate] .[defaultLabelId]
			WHERE 	[defaultLabelTranslate].[languageId]='".$_SESSION['languageId']."'";
	} else if ($q->vendor=='oracle') {
	$sql="
			SELECT	*
			FROM 	\"defaultLabel\"
			JOIN 	\"defaultLabelTranslate\"
			ON		\"defaultLabel\" .\"defaultLabelId\"=  \"defaultLabelTranslate\" .\"defaultLabelId\"
			WHERE 	\"defaultLabelTranslate\".\"languageId\"='".$_SESSION['languageId']."'";
	}
	$result	=	$q->fast($sql);
	while ($row = $q->fetchAssoc($result)) {



		echo "var ".$row['defaultLabel']." = '".$row['defaultLabelText']."';\n";
	  }

/**
*	 static variable
**/
$staffId='staffId';
$phpself='PHP_SELF';
?>
var filename = '<?php echo basename($_SERVER[$phpself]); ?>';
<?php  // get uniqueid

if($q->vendor=='normal' || $q->vendor=='mysql') {
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
	} else if ($q->vendor=='microsoft') {
			$sql	=
"	SELECT	*
	FROM	[leaf]
	JOIN	[leafAccess]
	ON 		[leaf].[leafId]= 	[leafAccess].[leafId]
	JOIN 	[leafTranslate]
	ON		[leafAccess].[leafId]	=[leafTranslate].[leafId]
	AND 	[leafTranslate].[leafId]= [leaf].[leafId]
	WHERE  	[leaf].[leafFilename]			=	'".basename($_SERVER[$phpself])."'
	AND  	[leafAccess].[staffId]			=	'".$_SESSION[$staffId]."'
	AND		[leafTranslate].[languageId]	=	'".$_SESSION['languageId']."'";
	} else if ($q->vendor=='oracle') {

			$sql	=
"	SELECT	*
	FROM	\"leaf\"
	JOIN	\"leafAccess\"
	ON 		\"leaf\".\"leafId\"= 	\"leafAccess\".\"leafId\"
	JOIN 	\"leafTranslate\"
	ON		\"leafAccess\".\"leafId\"	=\"leafTranslate\".\"leafId\"
	AND 	\"leafTranslate\".\"leafId\"= \"leaf\".\"leafId\"
	WHERE  	\"leaf\".\"leafFilename\"			=	'".basename($_SERVER[$phpself])."'
	AND  	\"leafAccess\".\"staffId\"			=	'".$_SESSION[$staffId]."'
	AND		\"leafTranslate\".\"languageId\"	=	'".$_SESSION['languageId']."'";
	}

$result	=	$q->fast($sql);

$row_leafAccess 		= 	$q->fetchAssoc($result);

?>

var leafId			= '<?php echo $row_leafAccess['leafId'];   ?>';
var leafName			= '<?php echo $row_leafAccess['leafTranslate'];   ?>';
var leafCreateAccessValue	= '<?php echo $row_leafAccess['leafCreateAccessValue'];   ?>';
var leafReadAccessValue		= '<?php echo $row_leafAccess['leafReadAccessValue'];   ?>';
var leafPrintAccessValue	= '<?php echo $row_leafAccess['leafPrintAccessValue'];   ?>';

</script>
