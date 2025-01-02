<?php

namespace Drupal\custom_field_type\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;

class RemoveFieldDependency extends ConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'remove_field_dependency';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete all dependency');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete all dependency');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('system.modules_uninstall');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Deleting field.
    $info_config = FieldConfig::loadByName('node', 'article', 'field_custom_field_type');
    if ($info_config) {
      $info_config->delete();
    }

    // Deleting field storage.
    $info_storage = FieldStorageConfig::loadByName('node', 'field_custom_field_type');
    if ($info_storage) {
      $info_storage->delete();
    }

    $form_state->setRedirect('system.modules_uninstall');
  }

}
