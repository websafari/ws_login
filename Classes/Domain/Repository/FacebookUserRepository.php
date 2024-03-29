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
 * Repository for FacebookUser, also connects to Facebook API.
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
class Tx_WsLogin_Domain_Repository_FacebookUserRepository extends Tx_WsLogin_Domain_Repository_UserRepository {

    /**
     * @var Tx_WsLogin_Service_FacebookService
     */
    protected $facebookService;

    /**
     * inject FacebookService
     *
     * @param Tx_WsLogin_Service_FacebookService $facebookService
     */
    public function injectFacebookService(Tx_WsLogin_Service_FacebookService $facebookService) {
        $this->facebookService = $facebookService;
    }

    /**
     * Gets the Facebook Id from logged in user from Facebook API.
     *
     * @return string Facebook Id.
     */
    public function getUserIdFromAPI() {
        $facebook = $this->facebookService->getFacebook();
        $userId = $facebook->getUser();

        if ($userId) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $userId = null;
            }
        }
        return $userId;
    }

    /**
     * Creates and returns FacebookUser from user data from Facebook API.
     *
     * @return Tx_WsLogin_Domain_Model_FacebookUser user created from FB API data.
     */
    public function getUserFromAPI() {
        $facebook = $this->facebookService->getFacebook();
        $userId = $facebook->getUser();
        $user_profile = null;

        if ($userId) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $userId = null;
            }
        }
        if (!$userId && !$user_profile) {
            return null;
        }

        /* @var $user Tx_WsLogin_Domain_Model_FacebookUser */
        $user = t3lib_div::makeInstance('Tx_WsLogin_Domain_Model_FacebookUser');
        $user->setWsFacebookId($userId);
        $user->setUsername($user_profile['username']);
        $user->setFirstName($user_profile['first_name']);
        $user->setLastName($user_profile['last_name']);
        $user->setName($user_profile['first_name'] . ' ' . $user_profile['last_name']);

        return $user;
    }

    /**
     * Gets FacebookUser from database by Facebook Id.
     *
     * @param string $ws_facebook_id
     * @return Tx_WsLogin_Domain_Model_FacebookUser user from database.
     */
    public function getUserByFBId($ws_facebook_id) {
        $query = $this->createQuery();
        return $query
            ->matching(
                $query->equals('ws_facebook_id', $ws_facebook_id)
            )
            ->execute()
            ->getFirst();
    }
}
?>