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
 * Class for creating and removing user sessions.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Websafari Social Login
 *
 * @author Florian Rachor <f.rachor@websafari.eu>
 * @author Peter Grassberger <p.grassberger@websafari.eu>
 * @author Augustin Malle <a.malle@websafari.eu>
 * @author Miladin Bojic <m.bojic@websafari.eu>
 */
class Tx_WsLogin_Service_LoginService implements t3lib_Singleton {

    /**
     * Creates a user session.
     *
     * The user to be logged must exist in the fe_users database.
     * If a user is already logged in, he is logged out.
     *
     * @param $uid int The uid of the user that shall be logged in.
     * @return bool The return value of @see isLoggedIn()
     */
    public function login($uid) {
        $this->logout();

        /** @var $fe_user tslib_feUserAuth */
        $fe_user = $GLOBALS['TSFE']->fe_user;
        $fe_user->createUserSession(array('uid' => $uid));
        $fe_user->user = $fe_user->getRawUserByUid($uid);
        $fe_user->fetchGroupData();
        $GLOBALS['TSFE']->loginUser = 1;

        return $this->isLoggedIn();
    }

    /**
     * Removes current user session.
     *
     * @return bool The inverse return value of @see isLoggedIn()
     */
    public function logout() {
        $GLOBALS['TSFE']->fe_user->logoff();
        $GLOBALS['TSFE']->loginUser = 0;

        return !$this->isLoggedIn();
    }

    /**
     * Checks if the User is logged in.
     *
     * This method is copied from @see Tx_Phpunit_Framework::isLoggedIn
     *
     * @return bool user logged in.
     */
    public function isLoggedIn() {
        return isset($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])
            && is_array($GLOBALS['TSFE']->fe_user->user);
    }

    /**
     * Returns the uid of the logged in user.
     *
     * If no user is logged in returns 0.
     *
     * @todo: should it return an exception when no user is logged in.
     *
     * @return int logged in user uid or zero.
     */
    public function getLoggedInUserUid() {
        if (!$this->isLoggedIn()) {
            return (int) 0;
        }
        /** @var $fe_user tslib_feUserAuth */
        $fe_user = $GLOBALS['TSFE']->fe_user;
        return (int) $fe_user->user['uid'];
    }

}
?>