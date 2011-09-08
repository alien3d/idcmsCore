<?php
	/*#######################################################################*
	 * File helper functions
	 *#######################################################################*/
	/**
	 * @param String $fileAbsolutePath
	 * @return Path of the provided file's directory, from the document root.
	 */
	function getDirectoryPathFromRoot($fileAbsolutePath) {
		return str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($fileAbsolutePath));
	}
	
	/*#######################################################################*
	 * Ext helper functions
	 *#######################################################################*/
	/**
	 * @return String url to the Ext root directory (doesn't include the trailing slash).
	 */
	function getExtRoot() {
		require_once("setUpEnvironment.php");
		$extVersion = "3.0.0";
		$extRoot = isProduction() ? "http://extjs.cachefly.net" : "";
		$extRoot .= "/ext-" . $extVersion;
		return $extRoot;
	}
?>