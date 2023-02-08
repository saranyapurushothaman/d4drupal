<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;


class CustomUserDetails extends FormBase {

    public function getFormId() {
        return "custom_user_details_form";
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['#attached']['library'][] = "custom_form/customjsform";
        $form['username'] = [
            '#type' => 'textfield',
            '#title' => 'User Name',
            '#required' => true,
        ];
        $form['usermail'] = [
            '#type' => 'email',
            '#title' => 'Email',
            '#required' => true,
        ];
        $form['usergender'] = [
            '#type' => 'select',
            '#title' => 'Gender',
            '#options' => [
                'male' => 'Male',
                'female' => 'Female',
                'other' => 'Other'
            ],
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Submit',
            '#ajax' => [
                'callback' => '::setAjaxSubmit',
            ],
        ];

        return $form;
    }

    public function setAjaxSubmit() {
        $response = new AjaxResponse();
        $response->addCommand(new InvokeCommand("html", 'datacheck'));
        return $response;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (strlen($form_state->getValue('username')) < 6) {
            $form_state->setErrorByname('username', "please make sure your username length is more than 5");
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        \Drupal::messenger()->addMessage("User Details Submitted Successfully");
        $values = $form_state->getValues();
        \Drupal::database()->insert('user_details')->fields([
            'name' => $values['username'],
            'mail' => $values['usermail'],
            'gender' => $values['usergender'],
        ])->execute();
    }
}
