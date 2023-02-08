<?php

namespace Drupal\custom_field_type\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Define the "custom field formatter".
 * 
 * @FieldFormatter(
 *   id = "custom_field_formatter",
 *   label = @Translation("Custom Field Formatter"),
 *   description = @Translation("Desc for Custom Field Formatter"),
 *   field_types = {
 *     "custom_field_type"
 *   }
 * )
 */


class CustomFieldFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return [
            'concat' => 'Concat with ',
        ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */

    public function settingsForm(array $form, FormStateInterface $form_state) {
        $form['concat'] =[
            '#type' => 'textfield',
            '#title' => 'Concatenate with',
            '#default_value' => $this->getSetting('concat'),
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = [];
        $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
        return $summary;
    }

    /**
     * {@inheritdoc}
     */

     public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = [];
    
        foreach ( $items as $delta => $item) {
            $element[$delta] = [
                '#markup' => $this->getSetting('concat') . $item->value,
            ];
        }
        return $element;
     }

}

