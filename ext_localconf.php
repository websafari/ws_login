<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Sl',
	array(
		'User' => 'showStatus, facebookLogin, twitterLogin, googleLogin, logout',
		
	),
	// non-cacheable actions
	array(
		'User' => '',
		
	)
);

?>