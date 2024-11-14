<?php

namespace Drupal\custom_form_modes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * An Article form controller.
 */
class ArticleForm extends ControllerBase {

  /**
   * Object of the node.
   */
  protected $node;

  /**
   * Returns a renderable array.
   *
   * return []
   */
  public function form(Node $node) {
    // Please, use dependency injection.
    $form = \Drupal::service('entity.form_builder')->getForm($node, 'article_form');
    return $form;
  }

}
