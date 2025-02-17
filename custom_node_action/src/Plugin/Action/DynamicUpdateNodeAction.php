<?php

namespace Drupal\custom_node_action\Plugin\Action;

use Drupal\Core\Action\ConfigurableActionBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides an action with a confirmation form before updating taxonomy terms.
 *
 * @Action(
 *   id = "custom_dynamic_update_taxonomy",
 *   label = @Translation("Dynamically update field_tags taxonomy terms"),
 *   type = "node"
 * )
 */
class DynamicUpdateNodeAction extends ConfigurableActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    if ($entity instanceof Node && !empty($this->configuration['selected_terms'])) { // 5,6,1
      // Retrieve existing term IDs.
      $current_terms = $entity->get('field_tags')->getValue();
      $existing_term_ids = array_column($current_terms, 'target_id'); // 1,2
      // Merge new terms with existing terms and remove duplicates.
      $updated_terms = array_unique(array_merge($existing_term_ids, $this->configuration['selected_terms'])); // 5,6,1,2
      $entity->set('field_tags', array_values($updated_terms));
      $entity->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    // Load only terms from the 'tags' vocabulary.
    $term_options = [];
    $query = \Drupal::entityQuery('taxonomy_term')
      ->condition('vid', 'tags')
      ->accessCheck(TRUE)
      ->execute();

    $terms = Term::loadMultiple($query);
    foreach ($terms as $term) {
      $term_options[$term->id()] = $term->getName();
    }

    $form['selected_terms'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select Terms'),
      '#description' => $this->t('Choose taxonomy terms to assign while running the action.'),
      '#options' => $term_options,
      '#default_value' => $this->configuration['selected_terms'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['selected_terms'] = array_filter($form_state->getValue('selected_terms'));

  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    return $object->access('update', $account, $return_as_object);
  }

}
