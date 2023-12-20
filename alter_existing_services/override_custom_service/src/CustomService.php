<?php

namespace Drupal\override_custom_service;

// use Drupal\Core\Session\AccountInterface;
use Drupal\module_with_service\UtilityServices;

class CustomService extends UtilityServices {

  // /**
  //  * The Current User object.
  //  *
  //  * @var \Drupal\Core\Session\AccountInterface
  //  */
  // protected $currentUser;

  // public function __construct(AccountInterface $current_user) {
  //   $this->currentUser = $current_user;
  // }

  // /**
  //  * Prints User ID.
  //  *
  //  * @return string
  //  */

  // public function printId() {
  //   return $this->currentUser->getEmail();
  // }

  /**
   * Prints Welcome message
   *
   * @return string
   */
  public function printMessage() {
    return "Welcome, " . $this->currentUser->getAccountName();
  }
}
