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
abstract class Tx_WsLogin_Domain_Model_User extends Tx_Extbase_Domain_Model_FrontendUser {

    /**
     * @return array
     */
    /*public function getUserDataArray() {
        $array = array(
            'uid' => $this->getUid(),
            'pid' => $this->getPid(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            // warning: "[warning:Tx_Extbase_Persistence_ObjectStorage:private] => You should never see this warning. ..."
            //'usergroup' => $this->getUsergroup(),
            'first_name' => $this->getFirstName(),
            'middle_name' => $this->getMiddleName(),
            'last_name' => $this->getLastName(),
            'address' => $this->getAddress(),
            'telephone' => $this->getTelephone(),
            'fax' => $this->getFax(),
            'email' => $this->getEmail(),
            'lockToDomain' => $this->getLockToDomain(),
            'title' => $this->getTitle(),
            'zip' => $this->getZip(),
            'city' => $this->getCity(),
            'country' => $this->getCountry(),
            'www' => $this->getWww(),
            'company' => $this->getCompany(),
            'image' => $this->getImage(),
            'lastlogin' => $this->getLastlogin(),
            'is_online' => $this->getIsOnline(),
        );

        return $array;
    }*/
}
?>