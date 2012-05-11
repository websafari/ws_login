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
 * Main Controller
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
class Tx_WsLogin_Controller_UserController extends Tx_Extbase_MVC_Controller_ActionController {

    /**
     * facebookUserRepository
     *
     * @var Tx_WsLogin_Domain_Repository_FacebookUserRepository
     */
    protected $facebookUserRepository;

    /**
     * googleUserRepository
     *
     * @var Tx_WsLogin_Domain_Repository_GoogleUserRepository
     */

    protected $googleUserRepository;

    /**
     * loginService
     *
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
     * injectGoogleUserRepository
     *
     * @param Tx_WsLogin_Domain_Repository_GoogleUserRepository $googleUserRepository
     * @return void
     */


    public function injectGoogleUserRepository(Tx_WsLogin_Domain_Repository_GoogleUserRepository $googleUserRepository) {
        $this->googleUserRepository = $googleUserRepository;
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
     * action showStatus displays status of the user.
     *
     * For example if the user is logged in or not.
     *
     * @return string $view
     */
    public function showStatusAction() {
        $loggedIn = $this->loginService->isLoggedIn();
        $this->view->assign('loggedIn', $loggedIn);

        return $this->view->render();
    }

    /**
     * action showLogin displays login "form".
     *
     * When the user is already logged in, a logout link is displayed.
     *
     * @return string $view
     */
    public function showLoginAction() {
        $loggedIn = $this->loginService->isLoggedIn();
        $this->view->assign('loggedIn', $loggedIn);

        return $this->view->render();
    }

	/**
	 * action facebookLogin adds or updates a FacebookUser it gets from the Repository.
     *
     * First this action tries to get the user from the api, if this fails it
     * redirects to Facebook for app approval. Then this action looks if the
     * user is persistent in the repository. If persistent, the user data is
     * updated. If not, the new user is added to the repository.
     *
     * An uid is needed to login the FacebookUser, the uid is only created
     * when the user is made persistent. The user becomes persistent when
     * this action ends. The only solution is to login the User, is to
     * redirect to an other action, in this chase
     * @see createFacebookSession().
	 *
     * @var $facebookUserDB Tx_WsLogin_Domain_Model_FacebookUser
     * @var $facebookUser Tx_WsLogin_Domain_Model_FacebookUser
     *
	 * @return void
	 */
	public function facebookLoginAction() {
        $facebookUserAPI = $this->facebookUserRepository->getUserFromAPI();
        if ($facebookUserAPI === null) {
            $this->redirectToUri($this->facebookUserRepository->getFacebook()->getLoginUrl());
            return;
        }
        $ws_facebook_id = $facebookUserAPI->getWsFacebookId();

        $facebookUserDB = $this->facebookUserRepository->getUserByFBId($ws_facebook_id);
        if ($facebookUserDB == null) {
            $this->facebookUserRepository->add($facebookUserAPI);
        } else {
            $facebookUserDB->setUsername($facebookUserAPI->getUsername());
            $facebookUserDB->setFirstName($facebookUserAPI->getFirstName());
            $facebookUserDB->setLastName($facebookUserAPI->getLastName());
            $facebookUserDB->setName($facebookUserAPI->getName());

            $this->facebookUserRepository->update($facebookUserDB);
        }

        $this->forward('createFacebookSession', 'User', NULL, array('ws_facebook_id' => $ws_facebook_id));
	}

    /**
     * action createFacebookSession creates FacebookUser Login Session.
     *
     * @param string $ws_facebook_id
     */
    public function createFacebookSessionAction($ws_facebook_id) {
        $facebookUserDB = $this->facebookUserRepository->getUserByFBId($ws_facebook_id);
        $this->loginService->login($facebookUserDB->getUid());

        $this->forward('showLogin');
    }

	/**
	 * action twitterLogin
	 *
     * @todo: implement
	 * @return void
	 */
	public function twitterLoginAction() {

	}

	/**
	 * action googleLogin
	 *
	 * @return void
	 */
	public function googleLoginAction() {

        /*
        require_once( t3lib_extMgm::extPath('ws_login') . 'Resources/PHP/google-php-sdk/GoogleOpenID.php');
        $getParams = $this->request->getArguments();
        if($_GET['ws_login']['googlelogin'] == 'login'){
            $googleLogin = GoogleOpenID::createRequest("/~miladinbojic/introductionpackage-4.6.8/index.php?id=75&no_cache=1&ws_login[googlelogin]=return");
            $googleLogin->redirect();
        }
        if($_GET['ws_login']['googlelogin'] == 'return'){
            $googleLogin = GoogleOpenID::getResponse();
            if($googleLogin->success()){
                $this->view->assign('loggedIn', TRUE);
                $user_id = $googleLogin->identity();
                $this->view->assign('user_id', $user_id);
            }
        }
        */

        /*
        $user_id = $this->googleUserRepository->getUserIdFromAPI();
        if($user_id) {
            $this->view->assign('loggedIn', TRUE);
            $this->view->assign('user_id', $user_id);
        }
        */
        return $this->view->render();
	}

    /**
     * action googleSignIn
     *
     * @return void
     */

    public function googleSignInAction() {
        /*
        $local_cObj = t3lib_div::makeInstance('tslib_cObj');
        $linkConf['parameter'] = $GLOBALS['TSFE']->id;
        $linkConf['additionalParams'] = '&tx_wslogin_loginform[action]=googleReturn';
        $linkConf['returnLast'] = 'url';
        $lastUrl = $local_cObj->typolink('', $linkConf);
        */
        require_once( t3lib_extMgm::extPath('ws_login') . 'Resources/PHP/google-php-sdk/GoogleOpenID.php');
        $googleLogin = GoogleOpenID::createRequest("/~miladinbojic/introductionpackage-4.6.8/index.php?id=".$GLOBALS['TSFE']->id."&tx_wslogin_loginform[action]=googleReturn");
        $googleLogin->redirect();

        return $this->view->render();
    }

    /**
     * action googleSignIn
     *
     * @return void
     */

    public function googleReturnAction() {
        /*
        $googleUserAPI = $this->googleUserRepository->getUserFromAPI();
        if($googleUserAPI){
            $this->view->assign('loggedIn', TRUE);
            $this->view->assign('user_id', $googleUserAPI);
        }
        */

        require_once( t3lib_extMgm::extPath('ws_login') . 'Resources/PHP/google-php-sdk/GoogleOpenID.php');
        $googleLogin = GoogleOpenID::getResponse();
        if($googleLogin->success()){
            $this->view->assign('loggedIn', TRUE);
            $user_id = $googleLogin->identity();
            $this->view->assign('user_id', $user_id);
        }

        return $this->view->render();
    }


	/**
	 * action logout logs out users.
	 *
	 * @return void
	 */
	public function logoutAction() {
        $this->loginService->logout();

        $this->forward('showLogin');
	}

}


?>