<?php

namespace Drupal\custom_config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomConfigForm extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "custom_config_form.settings";

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "custom_config_form_settings";
    }

    /**
     * {@inheritdoc}
     */

    protected function getEditableConfigNames() {
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $form['helptext'] = [
            '#type' => 'textfield',
            '#title' => 'Help Text',
            '#default_value' => $config->get("helptext"),
        ];

        // Token support.
        if (\Drupal::moduleHandler()->moduleExists('token')) {
            $form['tokens'] = [
                '#title' => $this->t('Tokens'),
                '#type' => 'container',
            ];
            $form['tokens']['help'] = [
                '#theme' => 'token_tree_link',
                '#token_types' => [
                'node',
                'site',
                'comment'
                ],
                // '#token_types' => 'all'
                '#global_types' => FALSE,
                '#dialog' => TRUE,
            ];
        }

        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("helptext", $form_state->getValue('helptext'));
        $config->save();
    }

}

