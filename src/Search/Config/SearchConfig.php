<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

require_once 'Zend/Registry.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Ini.php';

/**
 * Search configuration class.
 */
class SearchConfig {

  /** Search config file.  */
  const SEARCH_CONFIG_FILE = '/Search/Config/search_config.ini';

  /**
   * Get the current config. If it hasn't been stored in the registry yet,
   * add it.
   *
   * @return  Zend_Config_Ini  Loaded search config object
   */
  public static function getConfig() {
    $searchConfig = null;
    try {
      $searchConfig = Zend_Registry::get('search_config');
    } catch (Exception $e) {
      $searchConfig =
        new Zend_Config_Ini(INC_DIR . self::SEARCH_CONFIG_FILE);
      Zend_Registry::set('search_config', $searchConfig);
    }
    return $searchConfig;
  }

}

?>
