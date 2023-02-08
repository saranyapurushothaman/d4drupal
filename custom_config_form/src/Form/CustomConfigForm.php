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
        $form['firstname'] = [
            '#type' => 'textfield',
            '#title' => 'First Name',
            '#default_value' => $config->get("firstname"),
        ];

        $form['lastname'] = [
            '#type' => 'textfield',
            '#title' => 'Last Name',
            '#default_value' => $config->get("lastname"),
        ];

        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("firstname", $form_state->getValue('firstname'));
        $config->set("lastname", $form_state->getValue('lastname'));
        $config->save();
    }

}

