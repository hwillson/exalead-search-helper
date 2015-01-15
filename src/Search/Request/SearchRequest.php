<?php

/**
 * Search criteria container interface.
 *
 * @version  $Id:$
 */

interface SearchRequest {

  /**
   * Create an XML based request envelope.
   */
  public function createXmlRequestEnvelope();

}

?>
