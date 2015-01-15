<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

require_once 'Search/Criteria/SearchCriteria.php';

/**
 * Search criteria container.
 */
class ExaleadSearchCriteria implements SearchCriteria {

  const SORT_DESC = 0;
  const SORT_ASC = 1;

  /** Exalead search view. */
  private $view;

  /** Keyword search criteria. */
  private $keywordCriteria;

  /** Search within results keyword array. */
  private $narrowKeywordCriteria;

  /** Field search criteria array. */
  private $fieldCriteria;

  /** Numeric field search criteria array. */
  private $numericFieldCriteria;

  /** Range search criteria. */
  private $rangeCriteria;

  /** Result start ID (first hit id to show in results). */
  private $resultStartId;

  /** Number of results to allow. */
  private $resultCount;

  /** Number of results per results page. */
  private $resultsPerPage;

  /** Add refinement ID. */
  private $addRefinementId;

  /** Remove refinement ID. */
  private $removeRefinementId;

  /** Search context. */
  private $context;

  /** Search source restriction. */
  private $sourceRestriction;

  /** Sort on this field. */
  private $sortField;

  /** Sort on this alphanumeric field. */
  private $alphaSortField;

  /** Sort order. */
  private $sortOrder;

  /** Max number of pages to show for pagination. */
  private $pageRange;

  /** Is exact phrase search? */
  private $isExactPhraseSearch;

  private $customCriteria;

  /**
   * Constructor.
   */
  function __construct() {
    $this->fieldCriteria = array();
    $this->numericFieldCriteria = array();
    $this->resultStartId = 0;
    $this->resultCount = 100;
    $this->resultsPerPage = 100;
    $this->pageRange = 10;
    $this->removeNarrow = false;
    $this->sortOrder = self::SORT_ASC;
    $this->sourceRestriction = array();
    $this->narrowKeywordCriteria = array();
    $this->rangeCriteria = '';
    $this->isExactPhraseSearch = true;
  }

  public function getView() {
    return $this->view;
  }

  public function setView($view) {
    $this->view = $view;
  }

  /**
   * $keywordCriteria get method.
   *
   * @return  string  Keyword search criteria
   */
  public function getKeywordCriteria() {
    return $this->keywordCriteria;
  }

  /**
   * $keywordCriteria set method.
   *
   * @param  $keywordCriteria  Keyword search criteria
   */
  public function setKeywordCriteria($keywordCriteria) {
    $this->keywordCriteria = $keywordCriteria;
  }

  public function getRangeCriteria() {
    return $this->rangeCriteria;
  }

  public function setRangeCriteria($rangeCriteria) {
    $this->rangeCriteria = $rangeCriteria;
  }

  public function getNarrowKeywordCriteria() {
    return $this->narrowKeywordCriteria;
  }

  public function setNarrowKeywordCriteria($narrowKeywordCriteria) {
    $this->narrowKeywordCriteria = $narrowKeywordCriteria;
  }

  /**
   * $fieldCriteria get method.
   *
   * @return  Array  Field search criteria array
   */
  public function getFieldCriteria() {
    return $this->fieldCriteria;
  }

  /**
   * $fieldCriteria set method.
   *
   * @param  $fieldCriteria  Array of field search criteria
   */
  public function setFieldCriteria($fieldCriteria) {
    $this->fieldCriteria = $fieldCriteria;
  }

  public function getNumericFieldCriteria() {
    return $this->numericFieldCriteria;
  }

  public function setNumericFieldCriteria($numericFieldCriteria) {
    $this->numericFieldCriteria = $numericFieldCriteria;
  }

  public function getIsExactPhraseSearch() {
    return $this->isExactPhraseSearch;
  }

  public function setIsExactPhraseSearch($isExactPhraseSearch) {
    $this->isExactPhraseSearch = $isExactPhraseSearch;
  }

  /**
   * $resultStartId get method.
   *
   * @return  integer  Result start ID
   */
  public function getResultStartId() {
    return $this->resultStartId;
  }

  /**
   * $resultStartId set method.
   *
   * @param  $resultStartId  Result start ID
   */
  public function setResultStartId($resultStartId) {
    $this->resultStartId = $resultStartId;
  }

  /**
   * $resultCount get method.
   *
   * @return  integer  Result count
   */
  public function getResultCount() {
    return $this->resultCount;
  }

  /**
   * $resultCount set method.
   *
   * @param  $resultCount  Result count
   */
  public function setResultCount($resultCount) {
    $this->resultCount = $resultCount;
  }

  /**
   * $pageRange get method.
   *
   * @return  integer  Page range
   */
  public function getPageRange() {
    return $this->pageRange;
  }

  /**
   * $pageRange set method.
   *
   * @param  $pageRange  Page range
   */
  public function setPageRange($pageRange) {
    $this->pageRange = $pageRange;
  }

  /**
   * $resultsPerPage get method.
   *
   * @return  integer  Results per page
   */
  public function getResultsPerPage() {
    return $this->resultsPerPage;
  }

  /**
   * $resultsPerPage set method.
   *
   * @param  $resultsPerPage  Results per page
   */
  public function setResultsPerPage($resultsPerPage) {
    if (!empty($resultsPerPage)) {
      $this->resultsPerPage = $resultsPerPage;
    }
  }

  public function getAddRefinementId() {
    return $this->addRefinementId;
  }

  public function setAddRefinementId($addRefinementId) {
    $this->addRefinementId = $addRefinementId;
  }

  public function getRemoveRefinementId() {
    return $this->removeRefinementId;
  }

  public function setRemoveRefinementId($removeRefinementId) {
    $this->removeRefinementId = $removeRefinementId;
  }

  /**
   * $context set method.
   *
   * @param  $context  Search context
   */
  public function setContext($context) {
    $this->context = $context;
  }

  /**
   * $context get method.
   *
   * @return  string  Search context
   */
  public function getContext() {
    return $this->context;
  }

  /**
   * $sourceRestriction get method.
   *
   * @return  string  Source restriction
   */
  public function getSourceRestriction() {
    return $this->sourceRestriction;
  }

  /**
   * $sourceRestriction set method.
   *
   * @param  $sourceRestriction  Source restriction
   */
  public function setSourceRestriction($sourceRestriction) {
    $this->sourceRestriction = $sourceRestriction;
  }

  public function addSourceRestriction($sourceRestriction) {
    if (!empty($sourceRestriction)) {
      $this->sourceRestriction[] = $sourceRestriction;
    }
  }

  /**
   * $sortField get method.
   *
   * @return  string  Sort on this field
   */
  public function getSortField() {
    return $this->sortField;
  }

  /**
   * $sortField set method.
   *
   * @param  $sortField  Sort on this field
   */
  public function setSortField($sortField) {
    $this->sortField = $sortField;
  }

  /**
   * $alphaSortField get method.
   *
   * @return  string  Sort on this alphanumeric field
   */
  public function getAlphaSortField() {
    return $this->alphaSortField;
  }

  /**
   * $alphaSortField set method.
   *
   * @param  $alphaSortField  Sort on this alphanumeric field
   */
  public function setAlphaSortField($alphaSortField) {
    $this->alphaSortField = $alphaSortField;
  }

  /**
   * $sortOrder get method.
   *
   * @return  string  Sort order
   */
  public function getSortOrder() {
    return $this->sortOrder;
  }

  /**
   * $sortOrder set method.
   *
   * @param  $sortOrder  Sort order
   */
  public function setSortOrder($sortOrder) {
    $this->sortOrder = $sortOrder;
  }

  public function getCustomCriteria() {
    return $this->customCriteria;
  }

  public function setCustomCriteria($customCriteria) {
    $this->customCriteria = $customCriteria;
  }

  /**
   * Return a query string containing all field search criteria.
   *
   * @return  string  Query string containing field search criteria
   */
  public function getFieldQueryString() {
    $fieldQueryString = '';
    $fieldCriteria = $this->fieldCriteria;
    $hasNot = false;
    foreach ($fieldCriteria as $field => $criteria) {
      $criteria = $this->escapeOperators($criteria);
      if (!empty($criteria)) {
        if (preg_match('/^NOT /', $criteria)) {
        if ($hasNot == false) {
          $hasNot = true;
          $fieldQueryString .= 'corporate/tree:Top AND NOT ';
        } else {
          $fieldQueryString .= ' AND NOT ';
        }
        $criteria = preg_replace('/NOT /', '', $criteria, 1);
        $criteria = str_replace('NOT ', 'OR ', $criteria);
        $criteria = str_replace('"', '', $criteria);
        }
        $fieldQueryString .= ($field . ':' . $criteria . ' ');
      }
    }
    return $fieldQueryString;
  }

  /**
   * Return a query string containing all numeric field search criteria.
   *
   * @return  string  Query string containing numeric field search criteria
   */
  public function getNumericFieldQueryString() {
    $fieldQueryString = '';
    $fieldCriteria = $this->numericFieldCriteria;
    foreach ($fieldCriteria as $field => $criteria) {
      $criteria =
        str_replace(' OR ', ') OR (' . $field . ' = ', $criteria);
      $criteria =
        str_replace(' or ', ') OR (' . $field . ' = ', $criteria);
      if (!empty($criteria)) {
        if (ereg('[0-9]', $criteria)) {
        $fieldQueryString .=
          (' (' . $field . ' = ' . $criteria . ') ');
        } else {
        $fieldQueryString .= (' (' . $field . ' = 0) ');
        }
       }
    }
    if (!empty($fieldQueryString)) {
      $fieldQueryString = ' (' . $fieldQueryString . ')';
    }
    return $fieldQueryString;
  }

  /**
   * Return a query string containing keyword and field search criteria.
   *
   * @return  string  Query string containing keyword and field search
   *          criteria
   */
  public function getSearchQueryString() {
    $queryString = '';
    $count = 0;
    foreach ($this->sourceRestriction as $source) {
      if ($count == 0) {
        $queryString = '(';
      }
      $queryString .= 'corporate/tree:"' . $source . '" ';
      if ($count == count($this->sourceRestriction) - 1) {
        $queryString .= ') ';
        break;
      }
      $queryString .= ' OR ';
      $count++;
    }
    $queryString .= ' AND ( ';
    $keywordCriteria =
      ($this->getIsExactPhraseSearch()
      ? $this->escapeOperators($this->keywordCriteria)
      : $this->adjustCriteriaRegex($this->keywordCriteria));
    if (!empty($keywordCriteria)) {
      $queryString .= "$keywordCriteria ";
    }
    $queryString .=
      $this->getFieldQueryString() . ' '
      . $this->getNumericFieldQueryString() . ' '
      . $this->getRangeCriteria() . ' ) ';

    $customCriteria = $this->getCustomCriteria();
    if (!empty($customCriteria)) {
      $queryString .= " AND ($customCriteria) ";
    }

    return $queryString;
  }

  public function getNarrowKeywordQueryString() {
    $narrowKeywordCriteria = $this->narrowKeywordCriteria;
    $narrowKeywordQueryString = '';
    if (!empty($narrowKeywordCriteria)) {
      foreach ($narrowKeywordCriteria as $narrowCriteria) {
        $narrowCriteria =
        ($this->getIsExactPhraseSearch()
          ? $this->escapeOperators($narrowCriteria)
          : $this->adjustCriteriaRegex($narrowCriteria));
        $narrowKeywordQueryString .= "$narrowCriteria ";
      }
    }
    return $narrowKeywordQueryString;
  }

  private function escapeOperators($criteria) {

    $escapedCriteria = '';
    if (!empty($criteria)) {
      $escapedCriteria = str_replace('"', '\"', $criteria);
      $words = preg_split('/(\s+)/', $escapedCriteria);
      $numberOfWords = count($words);
      $count = 0;
      foreach ($words as &$word) {
        $word = strtolower($word);
        if (strpos($word, '?') !== false) {
          $word = '/' . str_replace('?', '.', $word) . '/';
        }
        if (strpos($word, '*') !== false) {
          $word = "[[[$word]]]";
        }
        $count++;
      }
      $escapedCriteria = '"' . implode(' ', $words) . '"';
      $escapedCriteria =
        str_replace(' OR ', '" OR "', $escapedCriteria);
      $escapedCriteria =
        str_replace(' or ', '" OR "', $escapedCriteria);
      $escapedCriteria =
        str_replace(' AND ', '" AND "', $escapedCriteria);
      $escapedCriteria =
        str_replace(' and ', '" AND "', $escapedCriteria);
      $escapedCriteria =
        str_replace(' NOT ', '" NOT "', $escapedCriteria);
      $escapedCriteria =
        str_replace(' not ', '" NOT "', $escapedCriteria);
      $escapedCriteria =
        str_replace('"NOT ', 'NOT "', $escapedCriteria);
      $escapedCriteria =
        str_replace('"not ', 'NOT "', $escapedCriteria);
      $escapedCriteria =
        preg_replace(
          '/NOT "(\w+)\s"/', 'NOT ${1}',
          $escapedCriteria);
      $escapedCriteria =
        preg_replace(
          '/ NEAR\/(\d+) /', '" NEAR/${1} "',
          $escapedCriteria);
      $escapedCriteria =
        preg_replace(
          '/ near\/(\d+) /', '" NEAR/${1} "',
          $escapedCriteria);
      $escapedCriteria =
        str_replace('"/', '/', $escapedCriteria);
      $escapedCriteria =
        str_replace('/"', '/', $escapedCriteria);

      /*
       * Wildcards do not work when using an exact match with quotes.
       * When a wildcard is used in a field search, remove the exact
       * match quotes and use the NEXT operator instead to simulate
       * an exact match.
       */
      if (strpos($escapedCriteria, '[[[') !== false) {
        $escapedCriteria =
        str_replace(' [[[', ' NEXT ', $escapedCriteria);
        $escapedCriteria =
        str_replace(']]] ', ' NEXT ', $escapedCriteria);
        $escapedCriteria =
        str_replace('"', '', $escapedCriteria);
        $escapedCriteria =
          str_replace('[[[', '', $escapedCriteria);
        $escapedCriteria =
          str_replace(']]]', '', $escapedCriteria);
      }

      $escapedCriteria = '(' . $escapedCriteria . ')';
    }
    return $escapedCriteria;

  }

  private function adjustCriteriaRegex($criteria) {
    $adjustedCriteria = null;
    if (!empty($criteria)) {
      $words = preg_split('/(\s+)/', $criteria);
      foreach ($words as &$word) {
        if (strpos($word, '?') !== false) {
          $word = '/' . str_replace('?', '.', $word) . '/';
          $word = str_replace('*', '.*', $word);
        }
      }
      $adjustedCriteria = implode(' ', $words);
    }
    return $adjustedCriteria;
  }

}

?>
