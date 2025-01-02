<?php

namespace Drupal\custom_field_type;

use Drupal\Core\Extension\ModuleUninstallValidatorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;

class ModuleUninstallValidator implements ModuleUninstallValidatorInterface {

  use StringTranslationTrait;

  /**
   * The field storage config storage.
   *
   * @var \Drupal\Core\Config\Entity\ConfigEntityStorageInterface
   */
  protected $fieldStorageConfigStorage;


  /**
   * Constructs a new FieldUninstallValidator.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->fieldStorageConfigStorage = $entity_type_manager->getStorage('field_storage_config');
  }

  /**
   * {@inheritdoc}
   */
  public function validate($module) {
    $reasons = [];
    if ($module == "custom_field_type") {
      if ($field_storages = $this->getFieldStoragesByModule($module)) {
        $fields_in_use = [];
        foreach ($field_storages as $field_storage) {
          if (!$field_storage->isDeleted()) {
            $fields_in_use[$field_storage->getType()][] = $field_storage->getLabel();
          }
        }
      }
      if (!empty($fields_in_use)) {
        $reasons[] = $this->t("There is a dependent to be deleted. <a href=':url'>Remove all dependency</a>.", [ ':url' => Url::fromRoute('custom.field.uninstall')->toString()]);
      }
    }
    return $reasons;
  }

  /**
   * Returns all field storages for a specified module.
   */
  protected function getFieldStoragesByModule($module) {
    return $this->fieldStorageConfigStorage->loadByProperties(['module' => $module, 'include_deleted' => TRUE]);
  }

}
