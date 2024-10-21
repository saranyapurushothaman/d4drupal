<?php

namespace Drupal\plugin_demo\Plugin\BlockData;

use Drupal\Core\Plugin\PluginBase;

/**
* @BlockData(
* id = "display_welcome",
* label = "Displays Welcome message"
* )
*/
class DisplayWelcome extends PluginBase implements
BlockDataInterface {

  public function label() {
    return $this->pluginDefinition['label'];
  }

  public function blockData(){
    $data = [
      '#markup' => "Hi, Welcome to custom plugin creation demo",
    ];
    return $data;
  }

}
