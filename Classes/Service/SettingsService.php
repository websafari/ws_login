<?php
/**
 * Service to get settings.
 *
 * (c) Sebastian Schreiber
 *
 * copied from here: http://pastie.org/1605142
 * @see http://lists.typo3.org/pipermail/typo3-project-typo3v4mvc/2011-February/008691.html
 */

/**
 * Settings service. Provides access to the plugin settings
 * coming from TypoScript, Flexform and the Plugin content element.
 */
class Tx_WsLogin_Service_SettingsService implements t3lib_Singleton {

    /**
     * @var mixed
     */
    protected $settings = NULL;

    /**
     * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * Injects the Configuration Manager and loads the settings
     *
     * @param Tx_Extbase_Configuration_ConfigurationManagerInterface An instance of the Configuration Manager
     * @return void
     */
    public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Returns all settings.
     *
     * @param string $extensionName
     * @param string $pluginName
     * @return mixed|null
     */
    public function getSettings($extensionName = NULL, $pluginName = NULL) {
        if ($this->settings === NULL) {
            $this->settings = $this->configurationManager->getConfiguration(
                Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
                $extensionName,
                $pluginName
            );
        }
        return $this->settings;
    }

    /**
     * Returns the settings at path $path, which is separated by ".", e.g. "pages.uid".
     * "pages.uid" would return $this->settings['pages']['uid'].
     *
     * If the path is invalid or no entry is found, false is returned.
     *
     * @param $path
     * @param string $extensionName
     * @param string $pluginName
     * @return mixed
     */
    public function getByPath($path, $extensionName = NULL, $pluginName = NULL) {
        return Tx_Extbase_Reflection_ObjectAccess::getPropertyPath(
            $this->getSettings($extensionName, $pluginName),
            $path
        );
    }

}

?>