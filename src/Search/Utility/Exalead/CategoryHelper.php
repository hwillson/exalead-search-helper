<?php

require_once 'Zend/Log.php';
require_once 'Search/Exception/IllegalArgumentException.php';

/**
 * Exalead Category helper.
 *
 * @version  $Id:$
 */
class CategoryHelper {

  public $script;
  public $request;

  function __construct($script, $request, $fieldParam)  {
    if (empty($script) || empty($request) || empty($fieldParam)) {
      Logger::logErrorAndThrow(
        new IllegalArgumentException(
          'Missing parameters needed to build URL.'));
    }
    $this->script = '/' . $script;
    $this->request = $request;
    $this->fieldParam = $fieldParam;
  }

  /**
   * TODO.
   */
  public function refinementUrl($categoryPath, $categoryId) {
    if (!isset($categoryPath) || !isset($categoryId)) {
      Logger::logErrorAndThrow(
        new IllegalArgumentException(
          'Invalid category refinment information. '));
    }
    $url = $this->getUrl();

    /*
     * Making sure if on a different page than the first page, that when
     * refining pagination is reset (otherwise the refinement may reduce
     * the returned data set to something that isn't visible on the
     * current page.
     */
    $url .= 'result_start_id=0&';

    $url .= $this->fieldParam . '=' . urlencode($categoryPath) . '&'
       .  'add_refine_id' . '=' . urlencode('+' . $categoryId)
      .   '&' . $this->fieldParam . '_category_id=' . $categoryId;
    Logger::logDebug("Category refinement URL: $url");
    return $url;
  }

  public function getUrl() {
    $url = $this->script . '?';
    foreach (array_keys($_REQUEST) as $requestParam) {
      if (($requestParam != $this->fieldParam)
          && ($requestParam != 'result_start_id')
          && ($requestParam != 'remove_refine_id')) {
        $url .=
          ($requestParam . '='
            . urlencode($_REQUEST[$requestParam]) . '&');
      }
    }
    Logger::logDebug("Category URL: $url");
    return $url;
  }

}

?>
