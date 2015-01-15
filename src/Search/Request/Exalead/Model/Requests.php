<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

require_once 'Search/Utility/Logger.php';
require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Request/Exalead/Model/ExaleadXmlRequest.php';

/**
 * Exalead XML "requests" element.
 */
class Requests implements ExaleadXmlRequest {

  /** XML namespace identifier. */
  const XML_NS = '';

  /** Search request. */
  private $searchRequest;

  /**
   * Constructor.
   */
  function __construct() { }

  /**
   * $searchRequests set method.
   *
   * @param  $searchRequest  $searchRequest
   */
  public function setSearchRequest($searchRequest) {
    $this->searchRequest = $searchRequest;
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
    $element = $dom->createElement('requests');
    if (isset($this->searchRequest)) {
      $element->appendChild($this->searchRequest->buildDom($dom));
    }
    return $element;
  }

}

?>
