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



require_once( t3lib_extMgm::extPath('ws_login') . 'Resources/PHP/google-php-sdk/GoogleOpenID.php');

/**
 *
 *
 * @package ws_login
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_WsLogin_Domain_Repository_GoogleUserRepository extends Tx_WsLogin_Domain_Repository_UserRepository {

    /**
     * @var Google
     */
    //protected $google;

    /**
     *
     */
    /*
    public function __construct() {
        //todo: config this in conf or ts...
        //$this->setGoogle(new GoogleOpenID(array('YOUR_APP_ID', 'YOUR_APP_SECRET')));
        //parent::__construct();
    }
    */

    /**
     * @param Google $google
     */
    /*
    public function setGoogle(Google $google) {
        $this->google = $google;
    }
    */
    /**
     * @return string
     */
    public function getUserIdFromAPI() {
        $googleLogin = GoogleOpenID::getResponse();
        if($googleLogin->success()){
            $user_id = $googleLogin->identity();
            return $user_id;
        }
    }

    /**
     * @return Tx_WsLogin_Domain_Model_GoogleUser
     */

}
?>