<?php

require_once 'Search/Response/SearchResponse.php';
require_once 'Search/Response/Exalead/Category.php';
require_once 'Search/Exception/IllegalArgumentException.php';
require_once 'Search/Utility/Logger.php';

/**
 * Exalead search result hit, extracted from the returned XML based search
 * result hit.  A hit holds the results for one match from a search query.
 *
 * @version  $Id:$
 */
class Hit {

  /** XML based hit. */
  private $xmlHit;

  /** Hit score. */
  private $score;

  /** Hit source. */
  private $source;

  /** Hit result field attributes. */
  private $fields;

  /** Hit index. */
  private $hitIndex;

  /** Hit URL. */
  private $url;

  /** Hit title. */
  private $title;

  /** Categories. */
  private $categories;

  /**
   * Constructor.
   *
   * @param  $xmlHit  XML based hit
   */
  function __construct($xmlHit) {
    if (empty($xmlHit)) {
      Logger::logErrorAndThrow(
        new IllegalArgumentException('Invalid XML Hit.'));
    }
    $this->hitIndex = 0;
    $this->fields = array();
    $this->xmlHit = $xmlHit;
    $this->extractMetaFromHit();
  }

  /**
   * $fields get method.
   *
   * @return  Array  Field attributes
   */
  public function getFields() {
    return $this->fields;
  }

  /**
   * $score get method.
   *
   * @return  int  Hit score
   */
  public function getScore() {
    return $this->score;
  }

  /**
   * $source get method.
   *
   * @return  string  Hit source
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * $hitIndex get method.
   *
   * @return  int  Hit index
   */
  public function getHitIndex() {
    return $this->hitIndex;
  }

  /**
   * $url get method.
   *
   * @return  string  URL
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * $title get method.
   *
   * @return  string  Title
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * $xmlHit get method.
   *
   * @return  string  XML hit
   */
  public function getXmlHit() {
    return $this->xmlHit;
  }

  /**
   * Get a specific field value.
   *
   * @param   $name   Name of field
   * @return  string  Field value
   */
  public function getField($name) {
    return $this->fields[$name];
  }

  /**
   * Get hit categories array.
   *
   * @return  array  Array of hit categories.
   */
  public function getCategories() {
    return $this->categories;
  }

  /**
   * Extract field attributes data from an XML based hit.
   */
  public function extractMetaFromHit() {

    $titleXml = $this->xmlHit->xpath('//*[@name="title"]');
    $this->title = strval($titleXml[0]->TextSeg);

    $this->url = strval($this->xmlHit['url']);
    $this->source = strval($this->xmlHit['source']);
    $this->score = intval($this->xmlHit['score']);
    $fieldAttributes = $this->xmlHit->xpath('//*[@name="fieldAttributes"]');
    foreach ($fieldAttributes as $fieldAttribute) {
      $name = trim($fieldAttribute->MetaString[0]);
      $value = trim($fieldAttribute->MetaString[1]);
      if ($this->fields[$name] == null) {
        $this->fields[$name] = $value;
      }
    }
    $hitIndex = $this->xmlHit->xpath('//*[@name="hitindex"]');
    $this->hitIndex = trim($hitIndex[0]);

    $categories = array();
    $categoriesXml = $this->xmlHit->xpath('//Category');
    foreach ($categoriesXml as $categoryXml) {
      $parentTitle = trim($categoryXml['title']);
      $childCategoryXml = $categoryXml->Category;
      if (!empty($childCategoryXml)) {
      $category =
        new Category(
        $parentTitle,
        trim($childCategoryXml['path']));
      $categories[strtolower($parentTitle)] = $category;
      }
    }
    $this->categories = $categories;

    Logger::logDebug(print_r($this->fields, true));
  }

}
