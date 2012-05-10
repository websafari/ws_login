<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Florian Rachor <f.rachor@websafari.eu>, websafari
 *  Peter Grassberger <p.grassberger@websafari.eu>, websafari
 *  Augustin Malle <a.malle@websafari.eu>, websafari
 *  Miladin Bojic <m.bojic@websafari.eu>, websafari
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package ws_login
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_WsLogin_Service_LoginService implements t3lib_Singleton {

    /**
     * @param $uid int
     * @return bool
     */
    public function login($uid) {
        //todo: fix session, user doesnt seem to stay logged in..

        $this->logout();

        $GLOBALS['TSFE']->fe_user->createUserSession(array());
        $GLOBALS['TSFE']->fe_user->user = $GLOBALS['TSFE']->fe_user->getRawUserByUid($uid);
        $GLOBALS['TSFE']->fe_user->fetchGroupData();
        $GLOBALS['TSFE']->loginUser = 1;

        return $this->isLoggedIn();
    }

    /**
     * @return bool
     */
    public function logout() {
        $GLOBALS['TSFE']->fe_user->logoff();
        $GLOBALS['TSFE']->loginUser = 0;

        return !$this->isLoggedIn();
    }

    /**
     * This method is copied from Tx_Phpunit_Framework::isLoggedIn
     *
     * @return bool
     */
    public function isLoggedIn() {
        return isset($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])
            && is_array($GLOBALS['TSFE']->fe_user->user);
    }

}
?>