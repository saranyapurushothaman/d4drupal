<?php

namespace Drupal\module_with_service;

use Drupal\Core\Session\AccountInterface;

class UtilityServices {

  /**
   * The Current User object.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  public function printId() {
    return $this->currentUser->id();
  }

  public function printMessage() {
    return "Hello, " . $this->currentUser->getAccountName();
  }

}
