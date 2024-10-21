<?php

namespace Drupal\plugin_demo\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
* @Annotation
*/

class BlockData extends Plugin {
  /**
  * The human-readable name.
  ** @var \Drupal\Core\Annotation\Translation
  *
  * @ingroup plugin_translatable
  */
public $label;

}
