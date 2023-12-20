<?php

namespace Drupal\override_custom_service;

use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OverrideCustomServiceServiceProvider extends ServiceProviderBase {
        // OverrideCustomService + ServiceProvider
  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $container
      // existing service.
      ->getDefinition('module_with_service.utilityservice')
      //Alternate service.
      ->setClass("Drupal\override_custom_service\CustomService");
      // Arguments for the new service
      // ->setArguments([new Reference('current_user')]);
  }

}
