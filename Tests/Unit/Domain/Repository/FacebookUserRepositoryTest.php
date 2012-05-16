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
     * Test case for class Tx_WsLogin_Domain_Repository_UserRepositoryTest.
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
class Tx_WsLogin_Domain_Repository_FacebookUserRepositoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

    /**
     * @var Tx_WsLogin_Domain_Repository_FacebookUserRepository
     */
    protected $fixture;

    /**
     * @var Tx_Phpunit_Framework
     */
    protected $testingFramework;

    /**
     * @var Facebook
     */
    protected $mockFacebook;

    /**
     * @var Tx_WsLogin_Service_FacebookService
     */
    protected $mockFacebookService;

    /**
     * @var int
     */
    protected $ws_facebook_id;

    public function setUp() {
        $this->testingFramework = new Tx_Phpunit_Framework('fe_users');
        $this->fixture = t3lib_div::makeInstance('Tx_WsLogin_Domain_Repository_FacebookUserRepository');

        $this->mockFacebook = $this->getMock(
            'Facebook',
            array('getUser', 'api'),
            array(),
            '',
            FALSE
        );
        $this->mockFacebookService = $this->getMock(
            'Tx_WsLogin_Service_FacebookService',
            array(
                'getFacebook',
            ),
            array(),
            '',
            FALSE
        );

        $this->fixture->injectFacebookService($this->mockFacebookService);

        $this->ws_facebook_id = '123456';
    }

    public function tearDown() {
        $this->testingFramework->cleanUp();
        unset($this->fixture);
        unset($this->mockFacebook);
        unset($this->mockFacebookService);
        unset($this->ws_facebook_id);
    }

    /**
     * @test
     */
    public function getUserIdFromAPIWorks() {
        $this->mockFacebookService->expects($this->once())
            ->method('getFacebook')
            ->will($this->returnValue($this->mockFacebook));

        $this->mockFacebook->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($this->ws_facebook_id));

        $userId = $this->fixture->getUserIdFromAPI();
    }

    /**
     * @test
     */
    public function getUserFromAPIWorks() {
        $this->mockFacebookService->expects($this->once())
            ->method('getFacebook')
            ->will($this->returnValue($this->mockFacebook));

        $this->mockFacebook->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($this->ws_facebook_id));

        $meArray = array(
            'username' => 'testname',
            'first_name' => 'testfirstname',
            'last_name' => 'testlastname',
            'local' => 'US',
        );

        $this->facebookMock->expects($this->once())
            ->method('api')
            ->with('/me')
            ->will($this->returnValue($meArray));

        /** @var Tx_WsLogin_Domain_Model_User */
        $user = $this->fixture->getUserFromAPI();

        $this->assertSame($meArray['username'], $user->getUsername());
        $this->assertSame($meArray['first_name'], $user->getFirstName());
        $this->assertSame($meArray['last_name'], $user->getLastName());
    }

    /**
     * @test
     */
    public function getUserByFBIdReturnsFBUserWithCorrectId() {
        // create fake entries
        $this->testingFramework->createRecord('fe_users', array(
            'pid' => 0,
            'ws_facebook_id' => $this->ws_facebook_id,
            'tx_extbase_type' => 'Tx_WsLogin_FacebookUser',
        ));

        // get result
        $facebookUser = $this->fixture->getUserByFBId($this->ws_facebook_id);

        // check result
        $this->assertSame(
            $this->ws_facebook_id,
            $facebookUser->getWsFacebookId()
        );
    }
}

?>