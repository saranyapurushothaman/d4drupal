<?php

 namespace Drupal\plugin_block_example\Plugin\Block;

 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Session\AccountInterface;
 use Drupal\Core\Access\AccessResult;
 use Drupal\Core\Form\FormStateInterface;
 use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
 use Symfony\Component\DependencyInjection\ContainerInterface;

 /**
  * Provides simple block for d4drupal.
  * @Block (
  * id = "plugin_block_example",
  * admin_label = "D4drupal Block"
  * )
  */

  class D4DrupalBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * @var AccountInterface $account
     */
protected $account;
    /**
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param Drupal\Core\Session\AccountInterface $account
     */

    public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $account) {
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->account = $account;
    }


    /**
     * {@inheritdoc}
     */

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('current_user')
      );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
      $prefix = $this->configuration['prefix'];
        return [
            "#markup" => $prefix . $this->account->getAccountName() . " Welcome to D4drupal Channel",
        ];
    }
    

    /**
     * {@inheritdoc}
     */

    protected function blockAccess(AccountInterface $account) {
      return AccessResult::allowedIfHasPermission($account, "d4drupal block access");
    }

    /**
     * {@inheritdoc}
     */

    public function defaultConfiguration() {
      return [
        'prefix' => "",
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
      $form['prefix'] = [
        '#type' => 'textfield',
        '#title' => 'Prefix Text',
        '#default_value' => $this->configuration['prefix'],
      ];
      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
      $this->configuration['prefix'] = $form_state->getValue('prefix');
    }
  
}
