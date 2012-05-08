<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

//Everything
/*Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Sl',
	'Social Login'
);*/

//Status
Tx_Extbase_Utility_Extension::registerPlugin(
    $_EXTKEY,
    'status',
    'Status (Social Login)'
);

//Login "Form"
Tx_Extbase_Utility_Extension::registerPlugin(
    $_EXTKEY,
    'loginForm',
    'Login Form (Social Login)'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Websafari Social Login');

t3lib_div::loadTCA('fe_users');
if (!isset($TCA['fe_users']['ctrl']['type'])) {
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$TCA['fe_users']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_user.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_user.tx_extbase_type.0','0'),
			),
			'size' => 1,
			'maxitems' => 1,
			'default' => 'Tx_WsLogin_User'
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
}

$TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'] = $TCA['fe_users']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_user','Tx_WsLogin_User');
t3lib_extMgm::addToAllTCAtypes('fe_users', $TCA['fe_users']['ctrl']['type'],'','after:hidden');

$tmp_ws_login_columns = array(

);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_ws_login_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_WsLogin_User','Tx_WsLogin_User');

$TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'] = $TCA['fe_users']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'] .= ',--div--;LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_user,';
$TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'] .= '';

t3lib_div::loadTCA('fe_users');
if (!isset($TCA['fe_users']['ctrl']['type'])) {
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$TCA['fe_users']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_twitteruser.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_twitteruser.tx_extbase_type.0','0'),
			),
			'size' => 1,
			'maxitems' => 1,
			'default' => 'Tx_WsLogin_TwitterUser'
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
}

$TCA['fe_users']['types']['Tx_WsLogin_TwitterUser']['showitem'] = $TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'];
$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_twitteruser','Tx_WsLogin_TwitterUser');
t3lib_extMgm::addToAllTCAtypes('fe_users', $TCA['fe_users']['ctrl']['type'],'','after:hidden');

$tmp_ws_login_columns = array(

	'ws_twitter_id' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_twitteruser.ws_twitter_id',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim,required'
		),
	),
);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_ws_login_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_WsLogin_TwitterUser','Tx_WsLogin_TwitterUser');

$TCA['fe_users']['types']['Tx_WsLogin_TwitterUser']['showitem'] = $TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'];
$TCA['fe_users']['types']['Tx_WsLogin_TwitterUser']['showitem'] .= ',--div--;LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_twitteruser,';
$TCA['fe_users']['types']['Tx_WsLogin_TwitterUser']['showitem'] .= 'ws_twitter_id';

t3lib_div::loadTCA('fe_users');
if (!isset($TCA['fe_users']['ctrl']['type'])) {
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$TCA['fe_users']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_facebookuser.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_facebookuser.tx_extbase_type.0','0'),
			),
			'size' => 1,
			'maxitems' => 1,
			'default' => 'Tx_WsLogin_FacebookUser'
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
}

$TCA['fe_users']['types']['Tx_WsLogin_FacebookUser']['showitem'] = $TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'];
$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_facebookuser','Tx_WsLogin_FacebookUser');
t3lib_extMgm::addToAllTCAtypes('fe_users', $TCA['fe_users']['ctrl']['type'],'','after:hidden');

$tmp_ws_login_columns = array(

	'ws_facebook_id' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_facebookuser.ws_facebook_id',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim,required'
		),
	),
);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_ws_login_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_WsLogin_FacebookUser','Tx_WsLogin_FacebookUser');

$TCA['fe_users']['types']['Tx_WsLogin_FacebookUser']['showitem'] = $TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'];
$TCA['fe_users']['types']['Tx_WsLogin_FacebookUser']['showitem'] .= ',--div--;LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_facebookuser,';
$TCA['fe_users']['types']['Tx_WsLogin_FacebookUser']['showitem'] .= 'ws_facebook_id';

t3lib_div::loadTCA('fe_users');
if (!isset($TCA['fe_users']['ctrl']['type'])) {
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$TCA['fe_users']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_googleuser.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_googleuser.tx_extbase_type.0','0'),
			),
			'size' => 1,
			'maxitems' => 1,
			'default' => 'Tx_WsLogin_GoogleUser'
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
}

$TCA['fe_users']['types']['Tx_WsLogin_GoogleUser']['showitem'] = $TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'];
$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_googleuser','Tx_WsLogin_GoogleUser');
t3lib_extMgm::addToAllTCAtypes('fe_users', $TCA['fe_users']['ctrl']['type'],'','after:hidden');

$tmp_ws_login_columns = array(

	'ws_google_id' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_googleuser.ws_google_id',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim,required'
		),
	),
);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_ws_login_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_WsLogin_GoogleUser','Tx_WsLogin_GoogleUser');

$TCA['fe_users']['types']['Tx_WsLogin_GoogleUser']['showitem'] = $TCA['fe_users']['types']['Tx_WsLogin_User']['showitem'];
$TCA['fe_users']['types']['Tx_WsLogin_GoogleUser']['showitem'] .= ',--div--;LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_googleuser,';
$TCA['fe_users']['types']['Tx_WsLogin_GoogleUser']['showitem'] .= 'ws_google_id';

			t3lib_extMgm::addLLrefForTCAdescr('tx_wslogin_domain_model_login', 'EXT:ws_login/Resources/Private/Language/locallang_csh_tx_wslogin_domain_model_login.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_wslogin_domain_model_login');
			$TCA['tx_wslogin_domain_model_login'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:ws_login/Resources/Private/Language/locallang_db.xml:tx_wslogin_domain_model_login',
					'label' => 'uid',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Login.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wslogin_domain_model_login.gif'
				),
			);

?>