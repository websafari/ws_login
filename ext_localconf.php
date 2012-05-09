<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

//Everything
/*Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Sl',
	array(
		'User' => 'showStatus, facebookLogin, twitterLogin, googleLogin, logout',
		
	),
	// non-cacheable actions
	array(
		'User' => '',
		
	)
);*/

//Status
Tx_Extbase_Utility_Extension::configurePlugin(
    $_EXTKEY,
    'status',
    array('User' => 'showStatus'),
    array('User' => 'showStatus')
);

//Login "Form"
Tx_Extbase_Utility_Extension::configurePlugin(
    $_EXTKEY,
    'loginForm',
    array('User' => 'showLogin, facebookLogin, twitterLogin, googleLogin, logout'),
    array('User' => 'showLogin, facebookLogin, twitterLogin, googleLogin, logout')
);

?>