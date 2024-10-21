<?php

namespace Drupal\plugin_demo;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

class BlockDataManager extends DefaultPluginManager {
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    // Passing plugin details to parent class.
    parent::__construct('Plugin/BlockData',$namespaces,$module_handler,'Drupal\plugin_demo\Plugin\BlockData\BlockDataInterface','Drupal\plugin_demo\Annotation\BlockData');
  }

}
