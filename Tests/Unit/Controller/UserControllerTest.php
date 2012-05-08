<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Florian Rachor <f.rachor@websafari.eu>, websafari
 *  			Peter Grassberger <p.grassberger@websafari.eu>, websafari
 *  			Augustin Malle <a.malle@websafari.eu>, websafari
 *  			Miladin Bojic <m.bojic@websafari.eu>, websafari
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Ws_login_Controller_UserController.
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
class Tx_WsLogin_Controller_UserControllerTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
    /**
     * @var Tx_WsLogin_Domain_Repository_FacebookUserRepository
     */
    protected $mockFacebookUserRepository;

    /**
     * @var Tx_WsLogin_Service_LoginService
     */
    protected $mockLoginService;

    /**
     * @var Tx_Fluid_View_TemplateView
     */
    protected $mockView;

    /**
     * @var Tx_WsLogin_Controller_UserController
     */
    protected $fixture;

    /**
     * @var string
     */
    protected $ws_facebook_id;

    /**
     * @var Tx_WsLogin_Domain_Model_FacebookUser
     */
    protected $facebookUser;

	public function setUp() {
        $this->ws_facebook_id = '123456';
        $this->facebookUser = new Tx_WsLogin_Domain_Model_FacebookUser();
        $this->facebookUser->setWsFacebookId($this->ws_facebook_id);

        $this->mockFacebookUserRepository = $this->getMock(
            'Tx_WsLogin_Domain_Repository_FacebookUserRepository',
            array(
                'getUserIdFromAPI',
                'getUserFromAPI',
                'getUserByFBId',
                'update',
                'add',
            ),
            array(),
            '',
            FALSE
        );
        $this->mockLoginService = $this->getMock(
            'Tx_WsLogin_Service_LoginService',
            array(
                'login',
                'logout',
                'isLoggedIn',
            ),
            array(),
            '',
            FALSE
        );
        $this->fixture = $this->getAccessibleMock(
            'Tx_WsLogin_Controller_UserController',
            array(
                'dummy', //this line is intended like this
            ),
            array(),
            '',
            FALSE
        );
        $this->mockView = $this->getMock(
            'Tx_Fluid_View_TemplateView',
            array(
                'assign',
                'render',
            ),
            array(),
            '',
            FALSE
        );

        $this->fixture->injectFacebookUserRepository($this->mockFacebookUserRepository);
        $this->fixture->injectLoginService($this->mockLoginService);
        $this->fixture->_set('view', $this->mockView);
    }

	public function tearDown() {
        unset($this->mockFacebookUserRepository);
        unset($this->mockLoginService);
        unset($this->mockView);
        unset($this->fixture);
        unset($this->ws_facebook_id);
        unset($this->facebookUser);
	}

    /**
     * @test
     */
    public function showStatusActionWorks() {
        $loggedIn = true;

        $this->mockLoginService->expects($this->once())
            ->method('isLoggedIn')
            ->will($this->returnValue($loggedIn));

        $this->mockView->expects($this->once())
            ->method('assign')
            ->with('loggedIn', $loggedIn);

        $this->fixture->showStatusAction();
    }

    /**
     * @test
     */
    public function facebookLoginActionWorksWhenUserExistsInDB() {
        $this->mockFacebookUserRepository->expects($this->once())
            ->method('getUserIdFromAPI')
            ->will($this->returnValue($this->ws_facebook_id));

        $this->mockFacebookUserRepository->expects($this->once())
            ->method('getUserByFBId')
            ->with($this->ws_facebook_id)
            ->will($this->returnValue($this->facebookUser));

        $this->mockFacebookUserRepository->expects($this->once())
            ->method('getUserFromAPI')
            ->will($this->returnValue($this->facebookUser));

        $this->mockFacebookUserRepository->expects($this->once())
            ->method('update')
            ->with(clone $this->facebookUser);

        $this->mockLoginService->expects($this->once())
            ->method('login')
            ->with($this->ws_facebook_id);

        $this->fixture->facebookLoginAction();
    }

    /**
     * @test
     */
    public function facebookLoginActionWorksWhenUserDoesntExistsInDB() {
        $this->mockFacebookUserRepository->expects($this->once())
            ->method('getUserIdFromAPI')
            ->will($this->returnValue($this->ws_facebook_id));

        $this->mockFacebookUserRepository->expects($this->once())
            ->method('getUserByFBId')
            ->with($this->ws_facebook_id)
            ->will($this->returnValue(null));

        $this->mockFacebookUserRepository->expects($this->once())
            ->method('getUserFromAPI')
            ->will($this->returnValue($this->facebookUser));

        // - expect it to add a new user to repository
        $this->mockFacebookUserRepository->expects($this->once())
            ->method('add')
            ->with(clone $this->facebookUser);

        $this->mockLoginService->expects($this->once())
            ->method('login')
            ->with($this->ws_facebook_id);

        $this->fixture->facebookLoginAction();
    }

    /**
     * @test
     */
    public function logoutActionWorks() {
        $this->mockLoginService->expects($this->once())
            ->method('logout');

        $this->fixture->logoutAction();
    }

}
?>