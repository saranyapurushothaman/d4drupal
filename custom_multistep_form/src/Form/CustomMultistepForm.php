<?php

namespace Drupal\custom_multistep_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomMultistepForm extends FormBase {

    public function getFormId() {
        return "custom_multistep_form";
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        if ($form_state->has("cpage") && $form_state->get("cpage") == 2) {
            return $this->secondForm($form, $form_state);
        }

        if ($form_state->has("cpage") && $form_state->get("cpage") == 3) {
            return $this->thirdForm($form, $form_state);
        }

        $form_state->set("cpage", 1);

        $form['firstname'] = [
            '#type' => 'textfield',
            '#title' => 'First Name',
            '#default_value' => $form_state->getValue("firstname"),
        ];

        $form['firstnext'] = [
            '#type' => 'submit',
            '#value' => 'Next',
            '#submit' => ['::firstNext'],
        ];
        return $form;

    }

    public function firstNext(array &$form, FormStateInterface $form_state) {

        $form_state->set("cpage", 2);
        $form_state->set("data", [
            'firstname' => $form_state->getValue("firstname"),
        ]);
        $form_state->setRebuild(TRUE);

    }

    public function secondForm(array $form, FormStateInterface $form_state) {
        $form['lastname'] = [
            '#type' => 'textfield',
            '#title' => 'Last Name',
            '#default_value' => $form_state->getValue("lastname"),
        ];

        $form['secondback'] = [
            '#type' => 'submit',
            '#value' => 'Back',
            '#submit' => ['::secondBack'],
        ];
        $form['secondnext'] = [
            '#type' => 'submit',
            '#value' => 'Next',
            '#submit' => ['::secondNext'],
        ];

        return $form;

    }

    public function secondBack(array &$form, FormStateInterface $form_state) {

        $form_state->setValues($form_state->get("data"));
        $form_state->set("cpage", 1);
        $form_state->setRebuild(TRUE);

    }

    public function secondNext(array &$form, FormStateInterface $form_state) {
        $values = $form_state->get("data");
        $form_state->set("cpage", 3);
        $form_state->set("data", [
            'firstname' => $values['firstname'],
            'lastname' => $form_state->getValue("lastname"),
        ]);
        $form_state->setRebuild(TRUE);


    }

    public function thirdForm(array $form, FormStateInterface $form_state) {

        $form['email'] = [
            '#type' => 'textfield',
            '#title' => 'Email ID',
        ];

        $form['thirdback'] = [
            '#type' => 'submit',
            '#value' => 'Back',
            '#submit' => ['::thirdBack'],
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Submit',
        ];

        return $form;

    }

    public function thirdBack(array &$form, FormStateInterface $form_state) {

        $form_state->setValues($form_state->get("data"));
        $form_state->set("cpage", 2);
        $form_state->setRebuild(TRUE);

    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

$mail = $form_state->getValue("email");
$values = $form_state->get("data");
$firstname = $values['firstname'];
$lastname = $values['lastname'];
$this->messenger()->addMessage($this->t("The form submitted successfully with Name: @first @last , Email: @mail", [
    '@first'=>$firstname,
    '@last' => $lastname,
    '@mail' => $mail,
]));

    }


}
