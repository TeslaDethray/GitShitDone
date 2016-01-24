<?php

// src/AppBundle/Model/Collection/DefaultCollection.php
namespace AppBundle\Model\Collection;

use AppBundle\Model\DefaultModel;
use Exception;
use Github\Client;
use Github\ResultPager;

abstract class DefaultCollection extends DefaultModel {

  /**
   * @var array
   */
  private $models;

  /**
   * Returns all models
   *
   * @return array
   */
  public function all() {
    if (!isset($this->models)) {
      $this->fetch();
    }
    return $this->models;
  }

  /**
   * Retrieves data concerning 
   *
   * @param string $action Name of action to take
   * @param array $options Options to accompany request
   * @return void
   * @throws Exception
   */
  public function fetch($action, $options = null) {
    if (!isset($this->api)) {
      throw new Exception(
        'The $api property not set in the {class} class.',
        ['class' => __CLASS__]
      );
    }
    $client = new Client();
    $paginator = new ResultPager($client);
    $results = $paginator->fetch($client->api($this->api), $action, $options);
    $models = [];
    $model = $this->getModelName();
    do {
      foreach ($results as $result) {
        if (isset($results['id']) && !isset($models[$results['id']]))) {
          $models[$results['id']] = new AppBundle\Model\$model($result);
        } else [
          $models[] = new AppBundle\Model\$model($result);
        }
      }
    } while ($paginator->hasNext() && $repos = $paginator->fetchNext());
    $this->models = $models;
  }

  /**
   * Returns a single model
   *
   * @return $this->getModelName()
   * @throws Exception
   */
  public function get($id) {
    if (!isset($this->models)) {
      $this->fetch();
    }
    if (isset($this->models[$id])) {
      return $this->models['id'];
    }
    throw new Exception(
      'A {model} with the ID {id} could not be found.',
      ['model' => $this->getModelName(), 'id' => $id]
    );
  }

  /**
   * Determines the name of the model for this class
   *
   * @return string
   * @throws Exception
   */
  private function getModelName() {
    preg_match("/(.*)Collection$/", __CLASS__, $model_array);
    if (empty($model_array)) {
      throw new Exception(
        'The {class} class is misnamed. It must end in "Collection".',
        ['class' => __CLASS__]
      );
    }
    return $model_array[1];
  }

}
