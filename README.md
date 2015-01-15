# Exalead Search Helper

PHP based [Exalead search](http://www.3ds.com/products-services/exalead/) helper library. Defines an object model for setting up searches, sending searches into Exalead's search API, and parsing/handling search responses.

## Sample Use
```
...
require_once 'Search/Criteria/Exalead/ExaleadSearchCriteria.php';
require_once 'Search/Request/Exalead/ExaleadSearchRequest.php';
require_once 'Search/Searcher/Exalead/ExaleadSearcher.php';
...
$searchCriteria = new ExaleadSearchCriteria();
$searchCriteria->setKeywordCriteria('search keywords');
$searcher = new ExaleadSearcher();
$searchRequest = new ExaleadSearchRequest($searchCriteria);
$searchResponse = $searcher->execute($searchRequest);
...

```

## TODO

- Mention of ZF1 dependencies
