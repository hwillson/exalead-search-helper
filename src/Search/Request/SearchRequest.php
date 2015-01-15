<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * Search criteria container interface.
 */
interface SearchRequest {

  /**
   * Create an XML based request envelope.
   */
  public function createXmlRequestEnvelope();

}

?>
