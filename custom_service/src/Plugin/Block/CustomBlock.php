<?php

 namespace Drupal\custom_service\Plugin\Block;

 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
 use Symfony\Component\DependencyInjection\ContainerInterface;
 use Drupal\custom_service\CustomService;


 /**
  * Provides simple block for d4drupal.
  * @Block (
  * id = "custom_service",
  * admin_label = "Custom Plugin Block"
  * )
  */


 class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * @var CustomService $service
     */
protected $service;
/**
 * @param array $configuration
 * @param string $plugin_id
 * @param mixed $plugin_definition
 * @param Drupal\custom_service\CustomService $service
 */

public function __construct(array $configuration, $plugin_id, $plugin_definition, CustomService $service) {
  parent::__construct($configuration, $plugin_id, $plugin_definition);
  $this->service = $service;
}


/**
 * {@inheritdoc}
 */

public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
  return new static(
    $configuration,
    $plugin_id,
    $plugin_definition,
    $container->get('custom_service')
  );
}

    /**
     * {@inheritdoc}
     */
    public function build() { // render function
        $element = [
          '#markup' => $this->service->text(),
        ];
          return $element;
      }


 }
