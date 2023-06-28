<?php

namespace Drupal\dynamic_title\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Function.
 */
class ControllerPage extends ControllerBase {
  public function PageTitle(Node $node) {
    if (!empty($node)) {
      $title = $node->getTitle();
      return [
        '#markup' => "Node of " . $title,
      ];
    }
  }

  public function NodeData(Node $node) {
    return [
        '#markup' => "Sample Controller Page",
    ];
  }

}
