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
class Tx_WsLogin_Controller_UserController extends Tx_Extbase_MVC_Controller_ActionController {

    /**
     * facebookUserRepository
     *
     * @var Tx_WsLogin_Domain_Repository_FacebookUserRepository
     */
    protected $facebookUserRepository;

    /**
     * @var Tx_WsLogin_Service_LoginService
     */
    protected $loginService;

    /**
     * injectFacebookUserRepository
     *
     * @param Tx_WsLogin_Domain_Repository_FacebookUserRepository $facebookUserRepository
     * @return void
     */
    public function injectFacebookUserRepository(Tx_WsLogin_Domain_Repository_FacebookUserRepository $facebookUserRepository) {
        $this->facebookUserRepository = $facebookUserRepository;
    }

    /**
     * injectLoginService
     *
     * @param Tx_WsLogin_Service_LoginService $loginService
     * @return void
     */
    public function injectLoginService(Tx_WsLogin_Service_LoginService $loginService) {
        $this->loginService = $loginService;
    }

    /**
     * action showStatus
     *
     * @return string
     */
    public function showStatusAction() {
        $loggedIn = $this->loginService->isLoggedIn();
        $this->view->assign('loggedIn', $loggedIn);

        return $this->view->render();
    }

    /**
     * action showLogin
     *
     * @return string
     */
    public function showLoginAction() {
        return $this->view->render();
    }

	/**
	 * action facebookLogin
	 *
     * @var $facebookUserDB Tx_WsLogin_Domain_Model_FacebookUser
     * @var $facebookUser Tx_WsLogin_Domain_Model_FacebookUser
     *
	 * @return void
	 */
	public function facebookLoginAction() {
        $ws_facebook_id = $this->facebookUserRepository->getUserIdFromAPI();
        //todo: check if an id was returned

        $facebookUserAPI = $this->facebookUserRepository->getUserFromAPI();
        /*if ($facebookUserAPI === null) {
            return;
            throw new ErrorException('$facebookUserAPI === null');
        }*/

        $facebookUserDB = $this->facebookUserRepository->getUserByFBId($ws_facebook_id);
        if ($facebookUserDB != null) {
            $this->facebookUserRepository->update($facebookUserAPI);
        } else {
            $this->facebookUserRepository->add($facebookUserAPI);
        }

        $this->loginService->login($ws_facebook_id);

        //todo: view or redirect
	}

	/**
	 * action twitterLogin
	 *
	 * @return void
	 */
	public function twitterLoginAction() {
        //todo: implement
	}

	/**
	 * action googleLogin
	 *
	 * @return void
	 */
	public function googleLoginAction() {
        //todo: implement
	}

	/**
	 * action logout
	 *
	 * @return void
	 */
	public function logoutAction() {
        $this->loginService->logout();

        //todo: view or redirect
	}

}
?>