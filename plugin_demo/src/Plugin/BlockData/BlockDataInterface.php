<?php
namespace Drupal\plugin_demo\Plugin\BlockData;

interface BlockDataInterface {
  /**
  * Get the plugin's label.
  */

  public function label();

  /**
  * returns block data.
  */
  public function blockData();

}
