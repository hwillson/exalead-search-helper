<?php

require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Utility/Logger.php';
require_once 'Search/Config/SearchConfig.php';
require_once 'Search/Response/Exalead/ExaleadSearchResponse.php';
require_once 'Search/Searcher/Searcher.php';
require_once 'Zend/Http/Client.php';

/**
 * Class used to perform searches.
 *
 * @version  $Id:$
 */
class ExaleadSearcher implements Searcher {

  private $searchServer;

  public function setSearchServer($searchServer) {
    $this->searchServer = $searchServer;
  }

  /**
   * Connect to the search engine, posting the passed in SearchRequest
   * information, and receive results.
   *
   * @param   $searchRequest      SearchRequest
   * @return  SearchResponse      Search response information,
   *                  including results
   * @throws  IllegalArgumentException  Invalid search request
   */
  public function execute($searchRequest) {

    if (!isset($searchRequest)) {
      Logger::logErrorAndThrow(
        new IllegalArgumentException('Invalid search request.'));
    }

    $searchHttpClient = null;
    $searchServer = $this->searchServer;
    $view = $searchRequest->getSearchCriteria()->getView();
    $searchUrl = SearchConfig::getConfig()->servers->search . "/$view";

    if (empty($searchServer)) {
      $searchHttpClient =
        new Zend_Http_Client(
          $searchUrl, array('timeout' => 600));
    } else {
      $searchHttpClient =
        new Zend_Http_Client(
          $searchServer, array('timeout' => 600));
    }

    $searchHttpResponse =
      $searchHttpClient->setRawData(
        $searchRequest->getXmlRequestEnvelope(),
          'text/xml')->request('POST');

    Logger::logDebug(
      'Search response XML: ' . $searchHttpResponse->getBody());
    return new ExaleadSearchResponse($searchRequest, $searchHttpResponse);

  }

}
