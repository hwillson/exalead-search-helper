<?php

/**
 * exalead-search-helper
 * https://github.com/hwillson/exalead-search-helper
 *
 * @author     Hugh Willson, Octonary Inc.
 * @copyright  Copyright (c)2015 Hugh Willson, Octonary Inc.
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * Search response.
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
