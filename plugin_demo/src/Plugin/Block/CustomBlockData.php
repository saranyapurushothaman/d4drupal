<?php

namespace Drupal\plugin_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\plugin_demo\BlockDataManager;

/**
 * Provides simple block to display custom block data.
 * @Block (
 * id = "custom_block_data",
 * admin_label = "Custom Block Data"
 * )
 */

class CustomBlockData extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var BlockDataManager $blockdatamanager
   */
  protected $blockdatamanager;

    /**
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param Drupal\plugin_demo\BlockDataManager $blockdatamanager
     */

    public function __construct(array $configuration, $plugin_id, $plugin_definition, BlockDataManager $blockdatamanager) {
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->blockdatamanager = $blockdatamanager;
    }

    /**
     * {@inheritdoc}
     */

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('plugin.manager.blockdata')
      );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
      $plugins_list = $this->configuration['plugins_list'];
      // Creates plugin object.
      $instance = $this->blockdatamanager->createInstance($plugins_list);
      // Function to return message based on plugin.
      return $instance->blockData();
    }

    /**
     * {@inheritdoc}
     */

    public function defaultConfiguration() {
      return [
        'plugins_list' => "",
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
      // Manager Discovers all plugins.
      $options[''] = "None";
      foreach ($this->blockdatamanager->getDefinitions() as $plugin_id => $definition) {
        $options[$plugin_id] = $definition['label'];
      }
      $form['plugins_list'] = [
        '#type' => 'select',
        '#title' => 'Select Plugin',
        '#default_value' => $this->configuration['plugins_list'],
        '#options' => $options,
      ];
      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
      // Save selected plugin.
      $this->configuration['plugins_list'] = $form_state->getValue('plugins_list');
    }
}
