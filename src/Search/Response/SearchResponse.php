<?php

/**
 * Search response.
 *
 * @version  $Id:$
 */
interface SearchResponse {

  /**
   * Return the search response as a SimpleXMLElement.
   *
   * @return  SimpleXMLElement  Search response as a simple XML element
   */
  public function getXmlResponse();

  /**
   * Return an array of result categories, that were created by the search.
   *
   * @return  Array  Array of Category objects
   */
  public function getCategories();

}
