<?php

require_once 'Search/Utility/Logger.php';
require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Request/Exalead/Model/ExaleadXmlRequest.php';

/**
 * Exalead XML "SearchRequest" element.
 *
 * @version  $Id:$
 */
class XmlSearchRequest implements ExaleadXmlRequest {

  /** XML namespace identifier. */
  const XML_NS = 'exa:com.exalead.search';

  /** Search request arguments. */
  private $args;

  /**
   * Constructor.
   */
  function __construct() {
    $this->args = array();
  }

  /**
   * Add and "Arg" to the $args array.
   *
   * @param  $arg  Arg
   */
  public function addArg($arg) {
    $this->args[] = $arg;
  }

  /**
   * Return the XML namespace identifier for the element.
   *
   * @return  string  XML namespace identifier
   */
  public function getXmlNs() {
    return self::XML_NS;
  }

  /**
   * Build a DOM representation of the current class and all of its
   * children.
   *
   * @param   $dom    DOMDocument
   * @return  DOMElement  DOM element
   */
  public function buildDom($dom) {
    if (!isset($dom)) {
      Logger::logErrorAndThrow(
        new IllegalArgumentException('Invalid DOMDocument.'));
    }
    $element = $dom->createElement('SearchRequest');
    $element->setAttribute('xmlns', $this->getXmlNs());
    $element->setAttribute('serviceId', '');
    $element->setAttribute('leftForwards', '15');
    foreach ($this->args as $arg) {
      $element->appendChild($arg->buildDom($dom));
    }
    return $element;
  }

}

?>
