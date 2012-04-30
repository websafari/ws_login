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
class Tx_WsLogin_Domain_Model_GoogleUser extends Tx_WsLogin_Domain_Model_User {

	/**
	 * Id for Google API
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $wsGoogleId;

	/**
	 * Returns the wsGoogleId
	 *
	 * @return string $wsGoogleId
	 */
	public function getWsGoogleId() {
		return $this->wsGoogleId;
	}

	/**
	 * Sets the wsGoogleId
	 *
	 * @param string $wsGoogleId
	 * @return void
	 */
	public function setWsGoogleId($wsGoogleId) {
		$this->wsGoogleId = $wsGoogleId;
	}

}
?>