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

    public function setUp() {
        $this->testingFramework = new Tx_Phpunit_Framework('fe_users');
        $this->fixture = new Tx_WsLogin_Domain_Repository_FacebookUserRepository();
    }

    public function tearDown() {
        $this->testingFramework->cleanUp();
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function getUserByFBIdReturnsFBUserWithCorrectId() {

        $ws_facebook_id = 'testid123abc';

        // create fake entries
        $this->testingFramework->createRecord('fe_users', array(
            'pid' => 0,
            'ws_facebook_id' => $ws_facebook_id,
            'tx_extbase_type' => 'Tx_WsLogin_FacebookUser',
        ));

        // get result
        $facebookUser = $this->fixture->getUserByFBId($ws_facebook_id);

        // check result
        $this->assertSame(
            $ws_facebook_id,
            $facebookUser->getWsFacebookId()
        );
    }

    /**
     * @test
     */
    public function dummyMethod() {
        $this->markTestIncomplete();
    }
}

?>