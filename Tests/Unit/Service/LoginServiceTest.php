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
 * Test case for class Tx_WsLogin_Service_LoginService.
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
class Tx_WsLogin_Service_LoginServiceTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

    /**
     * @var Tx_WsLogin_Service_LoginService
     */
    protected $fixture;

    /**
     * @var Tx_Phpunit_Framework
     */
    protected $testingFramework;

    public function setUp() {
        $this->testingFramework = new Tx_Phpunit_Framework('fe_users');
        $this->testingFramework->createFakeFrontEnd();

        $this->fixture = new Tx_WsLogin_Service_LoginService();
    }

    public function tearDown() {
        $this->testingFramework->cleanUp();
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function loginUserIsLoggedInCorrectly() {
        $pid = '3';
        $ws_facebook_id = '123456';
        $tx_extbase_type = 'Tx_WsLogin_FacebookUser';
        $username = 'testuser';

        // create fake entries
        $uid = $this->testingFramework->createRecord('fe_users', array(
            'pid' => $pid,
            'ws_facebook_id' => $ws_facebook_id,
            'tx_extbase_type' => $tx_extbase_type,
            'username' => $username,
        ));

        $this->fixture->login($uid);

        $this->assertTrue($this->testingFramework->isLoggedIn());
        $this->assertSame($pid, $GLOBALS['TSFE']->fe_user->user['pid']);
        $this->assertSame($ws_facebook_id, $GLOBALS['TSFE']->fe_user->user['ws_facebook_id']);
        $this->assertSame($tx_extbase_type, $GLOBALS['TSFE']->fe_user->user['tx_extbase_type']);
        $this->assertSame($username, $GLOBALS['TSFE']->fe_user->user['username']);
    }

    /**
     * @test
     */
    public function logoutUserIsLoggedOut() {
        $this->testingFramework->createAndLoginFrontEndUser();
        $this->fixture->logout();

        $this->assertFalse($this->testingFramework->isLoggedIn());
    }

    /**
     * @test
     */
    public function isLoggedInKnowsIfUserIsLoggedIn() {
        $this->testingFramework->createAndLoginFrontEndUser();
        $this->assertTrue($this->fixture->isLoggedIn());
    }

    /**
     * @test
     */
    public function isLoggedInKnowsIfUserIsLoggedOut() {
        $this->testingFramework->logoutFrontEndUser();
        $this->assertFalse($this->fixture->isLoggedIn());
    }

    /**
     * @test
     */
    public function getLoggedInUserUidReturnsLoggedInUserUid() {
        /** @var $uid integer */
        $uid = $this->testingFramework->createAndLoginFrontEndUser();
        $this->assertSame($uid, $this->fixture->getLoggedInUserUid());
    }

    /**
     * @test
     */
    public function getLoggedInUserUidReturnsZeroWhenNoUserLoggedIn() {
        $this->assertSame(0, $this->fixture->getLoggedInUserUid());
    }
}

?>