<?php

namespace Drupal\custom_service;

use Drupal\Core\Session\AccountInterface;

class CustomService {
/**
   * The account object.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $user;

    /**
   * Constructs a new CustomService class.
   *
   * @param \Drupal\Core\Session\AccountInterface $user
   *   The current user.
   */
  public function __construct(AccountInterface $user) {
    $this->user = $user;
  }


    public function text() {
        return "User Name: " . $this->user->getDisplayName();
    }

}

