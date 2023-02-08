<?php

namespace Drupal\custom_form\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomController extends ControllerBase {

    public function modalLink() {
        $build['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $build = [
            '#markup' => '<a href="/drupal10/web/get-user-details" class="use-ajax" data-dialog-type="modal">Click here</a>',
        ];
        return $build;
    }

}

