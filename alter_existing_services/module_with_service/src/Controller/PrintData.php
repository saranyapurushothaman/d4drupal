<?php

namespace Drupal\module_with_service\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for arg links task routes.
 */
class PrintData extends ControllerBase {

  /**
   * Returns message.
   */
  public function message() {
    $service = \Drupal::service("module_with_service.utilityservice");
    $message = $service->printMessage(); //hello, username.
    $id = $service->printId(); // uid.
    $build['content'] = [
      '#markup' => $message . " (" . $id . ")",
    ];

    return $build;
  }

}
