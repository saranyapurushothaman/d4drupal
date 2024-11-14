<?php

namespace Drupal\custom_view_modes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * An Article view page.
 */
class Articleview extends ControllerBase {

  /**
   * Object of the node.
   */
  protected $node;

  /**
   * Returns a renderable array.
   *
   * return []
   */
  public function view(Node $node) {
    // Please, use dependency injection.
    $viewBuilder = \Drupal::entityTypeManager()->getViewBuilder("node");
    $build = $viewBuilder->view($node, "article_view");
    return $build;
  }

}
