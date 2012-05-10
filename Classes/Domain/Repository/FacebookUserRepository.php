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


require_once( t3lib_extMgm::extPath('ws_login') . 'Resources/PHP/facebook-php-sdk/facebook.php');

/**
 *
 *
 * @package ws_login
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_WsLogin_Domain_Repository_FacebookUserRepository extends Tx_WsLogin_Domain_Repository_UserRepository {

    /**
     * @var Facebook
     */
    protected $facebook;

    /**
     *
     */
    public function __construct() {
        //todo: config this in conf or ts...
        //todo: reset App Secret when used elsewhere
        $this->setFacebook(new Facebook(array(
            'appId' =>'383342618383884',
            'secret' => 'f169724bfaef6c944815026a23718e1c')
        ));
        parent::__construct();
    }

    /**
     * @param Facebook $facebook
     */
    public function setFacebook(Facebook $facebook) {
        $this->facebook = $facebook;
    }

    /**
     * @return Facebook
     */
    public function getFacebook() {
        return $this->facebook;
    }

    /**
     * @return string
     */
    public function getUserIdFromAPI() {
        $userId = $this->facebook->getUser();

        if ($userId) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $userId = null;
            }
        }
        //todo: if there is no user, make him log in..
        return $userId;
    }

    /**
     * @return Tx_WsLogin_Domain_Model_FacebookUser
     */
    public function getUserFromAPI() {
        $userId = $this->facebook->getUser();
        $user_profile = null;

        if ($userId) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $userId = null;
            }
        }
        //todo: if there is no user, make him log in..
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
     * @param string $ws_facebook_id
     * @return Tx_WsLogin_Domain_Model_FacebookUser
     */
    public function getUserByFBId($ws_facebook_id) {
        $query = $this->createQuery();
        return $query
            ->matching(
                $query->like('ws_facebook_id', $ws_facebook_id)
            )
            ->execute()
            ->getFirst();
    }
}
?>