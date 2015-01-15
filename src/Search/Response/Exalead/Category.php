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
 * Search category.
 */
class Category {

  public $id;
  public $title;
  public $path;
  public $hitCount;
  public $subcategories;

  function __construct($title, $path, $id, $hitCount) {
    $this->subcategories = array();
    $this->title = $title;
    $this->id = $id;
    $this->path = $path;
    $this->hitCount = $hitCount;
  }

  public function hasSubcategory($path) {
    return array_key_exists($path, $this->subcategories);
  }

  public function addSubcategory($category) {
    if (!$this->hasSubcategory($category->path)) {
      $this->subcategories[$category->path] = $category;
    }
  }

  public function getSubcategories() {
    return $this->subcategories;
  }

  /**
   * Returns an array of subcategories sorted alphabetically by title.
   */
  public function getAlphaSortedSubcategories() {

    $subcategories = $this->subcategories;
    foreach ($subcategories as $subcategory) {
    $subcategoriesByTitle[$subcategory->title] = $subcategory;
    }

    ksort($subcategoriesByTitle);
    return array_values($subcategoriesByTitle);

  }

  /**
   * Return an array of subcategories, sorted first by hit count in
   * descending numerical order, then by title in ascending
   * alphanumeric order.
   */
  public function getSortedSubcategories() {

    $subcategories = $this->subcategories;
    foreach ($subcategories as $subcategory) {
    $sortedSubcategoryInfo[] =
      array(
      'hitCount' => $subcategory->hitCount,
      'title' => $subcategory->title,
      'subcategory' => $subcategory);
    }

    foreach ($sortedSubcategoryInfo as $key => $row) {
    $hitCounts[$key] = $row['hitCount'];
    $titles[$key] = strtolower($row['title']);
    }

    array_multisort(
    $hitCounts, SORT_DESC, SORT_NUMERIC,
    $titles, SORT_ASC, SORT_STRING, $sortedSubcategoryInfo);

    $sortedSubcategories = array();
    foreach ($sortedSubcategoryInfo as $subcategoryInfo) {
    $subcategory = $subcategoryInfo['subcategory'];
    $sortedSubcategories[$subcategory->path] = $subcategory;
    }
    return $sortedSubcategories;

  }

}

?>
