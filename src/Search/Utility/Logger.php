<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

require_once 'Zend/Log.php';
require_once 'Zend/Log/Writer/Stream.php';
require_once 'Zend/Registry.php';
require_once 'Search/Config/SearchConfig.php';

/**
 * Logging helper.
 */
class Logger {

  /**
   * Get the current logger.  If one hasn't been stored in the registry yet,
   * create one and add it.
   *
   * @return  Zend_Log  Loaded logger
   */
  public static function getLogger() {
    $logger = null;
    try {
      $logger = Zend_Registry::get('search_logger');
    } catch (Exception $e) {
      $logger =
        new Zend_Log(
          new Zend_Log_Writer_Stream(
            SearchConfig::getConfig()->logging->logfile));
      Zend_Registry::set('search_logger', $logger);
    }
    return $logger;
  }

  /**
   * Log an ERR level message.
   *
   * @param  $message  Message
   */
  public static function logError($message) {
    self::getLogger()->err($message);
  }

  /**
   * Log a DEBUG level message.
   *
   * @param  $message  Message
   */
  public static function logDebug($message) {
    self::getLogger()->debug($message);
  }

  /**
   * Log an error and throw the passed in exception.
   *
   * @param   $exception  Exception to log and throw
   * @throws  Exception   Exception that was logged
   */
  public static function logErrorAndThrow($exception) {
    self::logError('An exception has occured: ' . $exception);
    throw $exception;
  }

}

?>
