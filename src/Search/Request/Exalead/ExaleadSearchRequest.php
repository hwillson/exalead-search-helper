<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

require_once 'Search/Request/SearchRequest.php';
require_once 'Search/Request/Exalead/Model/RequestEnvelope.php';
require_once 'Search/Request/Exalead/Model/Requests.php';
require_once 'Search/Request/Exalead/Model/XmlSearchRequest.php';
require_once 'Search/Request/Exalead/Model/Arg.php';
require_once 'Search/Utility/Logger.php';

/**
 * Exalead search criteria container.
 */
class ExaleadSearchRequest implements SearchRequest {

  private $searchCriteria;
  private $xmlRequestEnvelope;

  function __construct($searchCriteria = null) {
    if (isset($searchCriteria)) {
      $this->searchCriteria = $searchCriteria;
      $this->createXmlRequestEnvelope();
    }
  }

  public function getSearchCriteria() {
    return $this->searchCriteria;
  }

  /**
   * $xmlRequestEnvelope get method.
   *
   * @return  string  $xmlRequestEnvelope
   */
  public function getXmlRequestEnvelope() {
    return $this->xmlRequestEnvelope;
  }

  /**
   * Create an XML based Exalead request envelope.
   */
  public function createXmlRequestEnvelope() {

    $requestEnvelope = new RequestEnvelope();
    $requests = new Requests();
    $searchRequest = new XmlSearchRequest();
    $searchRequest->addArg(new Arg('l', 'en'));

    if (!empty($this->searchCriteria)) {
      $searchRequest->addArg(
        new Arg('q', $this->searchCriteria->getSearchQueryString()));
      $searchRequest->addArg(
        new Arg('b', $this->searchCriteria->getResultStartId()));
      $searchRequest->addArg(
        new Arg('hf', $this->searchCriteria->getResultsPerPage()));
      $addRefinementId = $this->searchCriteria->getAddRefinementId();
      if (!empty($addRefinementId)) {
        $searchRequest->addArg(new Arg('r', $addRefinementId));
      }
      $removeRefinementId =
        $this->searchCriteria->getRemoveRefinementId();
      if (!empty($removeRefinementId)) {
        $searchRequest->addArg(new Arg('zr', $removeRefinementId));
      }
      $context = $this->searchCriteria->getContext();
      if (!empty($context)) {
        $searchRequest->addArg(new Arg('C', $context));
      }

      $searchRequest->addArg(
        new Arg(
          'noq',
          $this->searchCriteria->getNarrowKeywordQueryString()));

      $sortOrder =
        $this->searchCriteria->getSortOrder();
      $sortField =
        $this->searchCriteria->getSortField();
      if (!empty($sortField)) {
        $searchRequest->addArg(new Arg('s', $sortField));
        if ($sortOrder) {
          $searchRequest->addArg(new Arg('sa', $sortOrder));
        }
      }

      $alphaSortField =
        $this->searchCriteria->getAlphaSortField();

      if (!empty($alphaSortField)) {
        $value = $alphaSortField . ($sortOrder ? 'asc' : 'desc');
        $searchRequest->addArg(new Arg('_alpha19', $value));
      }

    }

    $requests->setSearchRequest($searchRequest);
    $requestEnvelope->setRequests($requests);

    $this->xmlRequestEnvelope = $requestEnvelope->getXml();

  }

  /**
   * String based representation of this object.
   *
   * @return  string  String based representation of this object
   */
  public function __toString() {
    return "ExaleadSearchRequest: \n".$this->xmlRequestEnvelope;
  }

}

?>
