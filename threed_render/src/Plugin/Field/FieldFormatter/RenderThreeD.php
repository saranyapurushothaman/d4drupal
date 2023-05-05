<?php

namespace Drupal\threed_render\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\file\Plugin\Field\FieldFormatter\DescriptionAwareFileFormatterBase;

/**
 * Plugin implementation of the 'threed_render' formatter.
 *
 * @FieldFormatter(
 *   id = "threed_render",
 *   label = @Translation("Render 3D Object"),
 *   field_types = {
 *     "file"
 *   }
 * )
 */
class RenderThreeD extends DescriptionAwareFileFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
        $file_url_generator = \Drupal::service('file_url_generator');
        $publicuri = "public://3dmodels/node/" . \Drupal::routeMatch()->getParameter("node")->id() . "/scene.gltf";
        $absolutepath = $file_url_generator->generateAbsoluteString($publicuri);

        $elements[$delta] = [
            "#theme" => "threed_render",
            '#path' => $absolutepath,
        ];
    }

    return $elements;
    }

}
