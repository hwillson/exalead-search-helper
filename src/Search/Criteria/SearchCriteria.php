<?php

/**
 * Search criteria interface.
 *
 * @version  $Id:$
 */
interface SearchCriteria {

  /**
   * $keywordCriteria get method.
   *
   * @return  string  Keyword search criteria
   */
  public function getKeywordCriteria();

  /**
   * $keywordCriteria set method.
   *
   * @param  $keywordCriteria  Keyword search criteria
   */
  public function setKeywordCriteria($keywordCriteria);


  /**
   * Return an Array of field search criteria.
   *
   * @return  Array  Field search criteria array
   */
  public function getFieldCriteria();

  /**
   * $fieldCriteria set method.
   *
   * @param  $fieldCriteria  Array of field search criteria
   */
  public function setFieldCriteria($fieldCriteria);

  /**
   * $resultStartId get method.
   *
   * @return  string  Result start ID
   */
  public function getResultStartId();

  /**
   * $resultStartId set method.
   *
   * @param  $resultStartId  Result start ID
   */
  public function setResultStartId($resultStartId);

  /**
   * $resultsPerPage get method.
   *
   * @return  integer  Results per page
   */
  public function getResultsPerPage();

  /**
   * $resultsPerPage set method.
   *
   * @param  $resultsPerPage  Results per page
   */
  public function setResultsPerPage($resultsPerPage);

}

?>
