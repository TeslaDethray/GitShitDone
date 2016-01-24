<?php

// src/AppBundle/Model/DefaultModel.php
namespace AppBundle\Model;

use Exception;
use Github\Client;
use Github\ResultPager;

abstract class DefaultModel {

  /**
   * @var array
   */
  private $attributes;
  /**
   * @var string
   */
  protected $api;

  /**
   * Object constructor
   *
   * @param array $attrbutes Attributes to retain about this object
   * @return DefaultModel
   */
  public function __construct(array $attributes = []) {
    $this->attributes = $attributes;
  }

  /**
   * Provides the requisite attribute
   * 
   * @param string $attribute Key of the attribute to retrieve
   * @return mixed
   * @throws Exception
   */
  public function get($attribute = null) {
    if (is_null($attribute)) {
      throw new Exception('No attribute name given.');
    }
    if (!isset($this->attributes[$attribute])) {
      throw new Exception(
        'Attribute {attribute} does not exist.',
        compact('attribute')
      );
    }
    return $this->attributes[$attribute];
  }

}
