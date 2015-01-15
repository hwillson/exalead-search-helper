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
 * Represents classes used to execute searches.
 */
interface Searcher {

  /**
   * Connect to the search engine, posting the passed in SearchRequest
   * information, and receive results.
   *
   * @param   $searchRequest      SearchRequest
   * @return  SearchResponse      Search response information,
   *                  including results
   * @throws  IllegalArgumentException  Invalid search request
   */
  public function execute($searchRequest);

}
