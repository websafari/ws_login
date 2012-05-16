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
     * Service class to initialize the Facebook php sdk
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
class Tx_WsLogin_Service_FacebookService implements t3lib_Singleton {

    /**
    * @var Tx_Extbase_Object_ObjectManagerInterface
    */
    protected $objectManager;

    /**
     * Facebook from @link https://github.com/facebook/facebook-php-sdk facebook-php-sdk
     *
     * @var Facebook
     */
    protected $facebook;

    /**
     * @var Tx_WsLogin_Service_SettingsService
     */
    protected $settingsService;

    /**
     * inject ObjectManager
     *
     * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
        $this->objectManager = $objectManager;
    }

    /**
     * inject SettingsService
     *
     * @param Tx_WsLogin_Service_SettingsService $settingsService
     */
    public function injectSettingsService(Tx_WsLogin_Service_SettingsService $settingsService) {
        $this->settingsService = $settingsService;
    }

    /**
     * initializes the Facebook class
     *
     * This function is automatically called after all dependency injections.
     */
    public function initializeObject() {
        $appId = $this->settingsService->getByPath('facebook-api.appId');
        $secret = $this->settingsService->getByPath('facebook-api.secret');
        debug($secret);

        $this->facebook = $this->objectManager->create(
            'Facebook',
            array(
                'appId' => $appId,
                'secret' => $secret
            )
        );
    }

    /**
     * Get Facebook
     *
     * @return Facebook
     */
    public function getFacebook() {
        return $this->facebook;
    }

}
?>