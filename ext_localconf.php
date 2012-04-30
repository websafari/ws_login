<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Sl',
	array(
		'User' => 'facebookLogin, twitterLogin, googleLogin, logout, showStatus',
		
	),
	// non-cacheable actions
	array(
		'User' => '',
		
	)
);

?>