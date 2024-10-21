<?php

namespace Drupal\plugin_demo\Plugin\BlockData;

use Drupal\Core\Plugin\PluginBase;

/**
* @BlockData(
* id = "display_date_time",
* label = "Displays Date and Time"
* )
*/
class DisplayDateTime extends PluginBase implements
BlockDataInterface {

  public function label() {
    return $this->pluginDefinition['label'];
  }

  public function blockData(){
    // Use dependency injection.
    $current_time = \Drupal::time()->getCurrentTime();
    $date_output = date('d/m/Y', $current_time);
    $data = [
      '#markup' => $date_output,
    ];
    return $data;
  }

}
