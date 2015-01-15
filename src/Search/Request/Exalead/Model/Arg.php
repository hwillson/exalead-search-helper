<?php

require_once 'Search/Utility/Logger.php';
require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Request/Exalead/Model/ExaleadXmlRequest.php';

/**
 * Exalead XML "Arg" element.
 *
 * @version  $Id:$
 */
class Arg implements ExaleadXmlRequest {

  /** XML namespace identifier. */
  const XML_NS = 'exa:com.exalead.xmlapplication';

  /** Arg name. */
  private $name;

  /** Arg value. */
  private $value;

  /**
   * Constructor.
   */
  function __construct($name = null, $value = null) {
    $this->name = $name;
    $this->value = $value;
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
    $element = $dom->createElement('Arg');
    $element->setAttribute('xmlns', $this->getXmlNs());
    $element->setAttribute('name', $this->name);
    $element->setAttribute('value', $this->value);
    return $element;
  }

}

?>
