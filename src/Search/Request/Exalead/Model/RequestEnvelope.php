<?php

require_once 'Search/Utility/Logger.php';
require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Request/Exalead/Model/ExaleadXmlRequest.php';

/**
 * Exalead XML request envelope.
 *
 * @version  $Id:$
 */
class RequestEnvelope implements ExaleadXmlRequest {

  /** XML namespace identifier. */
  const XML_NS = 'exa:com.exalead.xmlapplication';

  /** XML version. */
  const XML_VERSION = '1.0';

  /** Requests. */
  private $requests;

  /**
   * Constructor.
   */
  function __construct() {
    $this->requests = array();
  }

  /**
   * $requests set method.
   *
   * @param  $requests  $requests
   */
  public function setRequests($requests) {
    $this->requests = $requests;
  }

  /**
   * Return the XML representation of the current class and all of its
   * children.
   *
   * @return  string  XML representation
   */
  public function getXml() {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $this->buildDom($dom);
    $xml = $dom->saveXML();
    Logger::logDebug("Search request XML: $xml");
    return $dom->saveXML();
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
    $element = $dom->createElement('RequestEnvelope');
    $dom->appendChild($element);
    $element->setAttribute('xmlns', $this->getXmlNs());
    $element->setAttribute('version', self::XML_VERSION);
    if (!empty($this->requests)) {
      $element->appendChild($this->requests->buildDom($dom));
    }
    return $element;
  }

}

?>
