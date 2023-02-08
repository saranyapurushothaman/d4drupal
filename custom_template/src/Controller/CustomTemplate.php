<?php

namespace Drupal\custom_template\Controller;

use Drupal\Core\Controller\ControllerBase;


class CustomTemplate extends ControllerBase {

    public function customTemplate() {

        return [
            '#theme' => 'custom_template',
            '#text' => 'Welcome to our D4Drupal Channel',
        ];

    }

}
