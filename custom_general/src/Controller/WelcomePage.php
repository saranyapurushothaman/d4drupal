<?php

namespace Drupal\custom_general\Controller;
use Drupal\user\UserInterface;

/**
 * Welcome message print.
 */

class WelcomePage {
    /**
     * Welcome message.
     */
    public function welcomePage(UserInterface $user) 
    {
       $username =  $user->label();
       return [
        '#markup' => 'Hello ' . $username .  ', Welcome to our website',
       ];
    }
}
