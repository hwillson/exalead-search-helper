<?php

/**
 * Exalead XML name space identifier.
 *
 * @version  $Id:$
 */
interface ExaleadXmlRequest {

  /**
   * Return the XML namespace identifier for the element.
   *
   * @return  string  XML namespace identifier
   */
  public function getXmlNs();

  /**
   * Build a DOM representation of the current class and all of its
   * children.
   *
   * @param   $dom    DOMDocument
   * @return  DOMElement  DOM element
   */
  public function buildDom($dom);

}

?>
