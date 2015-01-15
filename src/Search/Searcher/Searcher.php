<?php

/**
 * Represents classes used to execute searches.
 *
 * @version  $Id:$
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
