<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

require_once 'Search/Response/SearchResponse.php';
require_once 'Search/Response/Exalead/Hit.php';
require_once 'Search/Response/Exalead/Category.php';
require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Utility/Logger.php';

/**
 * Exalead search response.
 */
class ExaleadSearchResponse implements SearchResponse {

  /** HTTP request. */
  private $httpRequest;

  /** HTTP response. */
  private $httpResponse;

  /** XML search response. */
  private $xmlResponse;

  /**
   * Constructor.
   *
   * @param  $httpResponse  HTTP search response
   */
  function __construct($httpRequest = null, $httpResponse = null) {
    if (!empty($httpRequest) && !empty($httpResponse)) {
      $body = $httpResponse->getBody();
      if (empty($body)) {
        Logger::logErrorAndThrow(
          new IllegalArgumentException(
            'Invalid HTTP search response body.'));
      }
      $this->httpRequest = $httpRequest;
      $this->httpResponse = $httpResponse;
      $this->setXmlResponse(
        $httpResponse->getBody(), 'ans', 'exa:com.exalead.search.v10');
    }
  }

  public function getHttpResponse() {
    return $this->httpResponse;
  }

  /**
   * Return the search response as a SimpleXMLElement.
   *
   * @return  SimpleXMLElement  Search response as a simple XML element
   */
  public function getXmlResponse() {
    return $this->xmlResponse;
  }

  public function setXmlResponse($xml, $namespaceKey, $namespaceValue) {
    $this->xmlResponse = new SimpleXMLElement($xml);
    $this->xmlResponse->registerXPathNamespace(
      $namespaceKey, $namespaceValue);
  }

  /**
   * Return the XML Answer.
   *
   * @return  SimpleXMLElement  XML Answer
   */
  public function getAnswer() {
    $answers = $this->xmlResponse->xpath('//ans:Answer');
    return $answers[0];
  }

  /**
   * Return the search context.
   *
   * @return  string  Search context
   */
  public function getContext() {
    $answer = $this->getAnswer();
    return trim($answer['context']);
  }

  /**
   * Return the total number of hits found.
   *
   * @return  string  Total number of hits
   */
  public function getTotalHits() {
    $answer = $this->getAnswer();
    $totalHits = $answer['nmatches'];
    return $totalHits;
  }

  /**
   * Return an array of search result Hits.
   *
   * @return  Array  Search result hits
   */
  public function getHits() {
    $hits = array();
    $xmlHits = $this->xmlResponse->xpath('//ans:Hit');
    foreach ($xmlHits as $xmlHit) {
      $hit = new Hit(new SimpleXMLElement($xmlHit->asXML()));
      $hits[] = $hit;
    }
    return $hits;
  }

  public function getSortedHits($key1, $order1, $key2, $order2) {

    $hits = $this->getHits();
    foreach ($hits as $hit) {
    $sortedHitInfo[] =
      array(
      $key1 => $hit->getField($key1),
      $key2 => $hit->getField($key2),
      'hit' => $hit);
    }

    foreach ($sortedHitInfo as $key => $row) {
    $value1s[$key] = $row[$key1];
    $value2s[$key] = $row[$key2];
    }

    array_multisort(
    $value1s, $order1, SORT_STRING,
    $value2s, $order2, SORT_STRING, $sortedHitInfo);

    $sortedHits = array();
    foreach ($sortedHitInfo as $hitInfo) {
    $hit = $hitInfo['hit'];
    $sortedHits[] = $hit;
    }
    return $sortedHits;

  }

  public function getHighlightedTerms() {
    $highlightInfo = $this->xmlResponse->xpath('//ans:HighlightRegexp');
    $highlightedTerms = array();
    for ($i = 0; $i < count($highlightInfo); $i++) {
      $highlightedTerms[] = strval($highlightInfo[$i]);
    }
    return $highlightedTerms;
  }

  /**
   * Return an array of result categories, that were created by the search.
   *
   * @return  Array  Array of Category objects
   */
  public function getCategories() {
    $xmlAnswerGroups = $this->xmlResponse->xpath('//ans:AnswerGroup');
    $categories = array();
    foreach ($xmlAnswerGroups as $xmlAnswerGroup) {
      $id = trim($xmlAnswerGroup['id']);
      $path = trim($xmlAnswerGroup['id']);
      $title = trim($xmlAnswerGroup['id']);
      $parentCategory = null;
      if (!array_key_exists($path, $categories)) {
        $parentCategory =
          new Category($title, $path, $id, null);
        $categories[$path] = $parentCategory;
      } else {
        $parentCategory = $categories[$path];
      }
      $xmlChildCategories =
        $xmlAnswerGroup->categories->Category;
      foreach ($xmlChildCategories as $xmlChildCategory) {
        $childTitle = trim($xmlChildCategory['title']);
        if ($childTitle != $title) {
          $childId = trim($xmlChildCategory['id']);
          $childPath = trim($xmlChildCategory['path']);
          $childHitCount = trim($xmlChildCategory['count']);
          $childCategory =
            new Category
              ($childTitle, $childPath, $childId, $childHitCount);
          $parentCategory->addSubcategory($childCategory);
        }
      }
    }
    return $categories;
  }

  public function getSpellingSuggestion() {
    $xmlSuggestions = $this->xmlResponse->xpath('//ans:Suggestion');
    $suggestion = '';
    if (!empty($xmlSuggestions) && (count($xmlSuggestions) > 0)) {
      $xmlChoice = $xmlSuggestions[0]->choices[0]->SuggestionChoice;
      $suggestion = strval($xmlChoice);
    }
    return $suggestion;
  }

  public function getExactMatchSpellingSuggestion() {
    $xmlSuggestions = $this->xmlResponse->xpath('//ans:Suggestion');
    $fullSuggestion = '';
    if (!empty($xmlSuggestions) && (count($xmlSuggestions) > 0)) {
      $searchCriteria = $this->httpRequest->getSearchCriteria();
      $originalKeywords = $searchCriteria->getKeywordCriteria();
      $splitKeywords = split(' ', $originalKeywords);
      $matchPos = 0;
      foreach ($xmlSuggestions as $xmlSuggestion) {
        $xmlChoice = $xmlSuggestion->choices[0]->SuggestionChoice;
        $query = $xmlChoice['query'];
        $suggestion = strval($xmlChoice);
        $index = 0;
        foreach ($splitKeywords as $keyword) {
          if (!strstr($query, $keyword)
              && (($matchPos == 0) || ($index > $matchPos))) {
            $splitKeywords[$index] = $suggestion;
            $matchPos = ($index + 1);
          }
          $index++;
        }
      }
      $fullSuggestion = join(' ', $splitKeywords);
    }
    return $fullSuggestion;
  }

  /**
   * Return an array of query phrases that were extracted from submitted
   * search query.
   *
   * @return  Array  Array of search query phrases
   */
  public function getQueryPhrases() {
    $xmlQueryPhrases = $this->xmlResponse->xpath('//ans:QueryPhrase');
    $queryPhrases = array();
    foreach ($xmlQueryPhrases as $xmlQueryPhrase) {
      $queryPhrase = strval($xmlQueryPhrase['value']);
      $queryPhrases[] = $queryPhrase;
    }
    return $queryPhrases;
  }

}
