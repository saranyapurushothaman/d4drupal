<?php

namespace Drupal\custom_batch\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class CustomBatchProcess extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "custom_batch_process.setting";

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "custom_batch_process_settings";
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
        $form['texttoadd'] = [
          '#type' => 'textfield',
          '#title' => 'Text to prepend in title',
          '#default_value' => $config->get("texttoadd"),
        ];
        // Load all content types to make options.
        $content_types = \Drupal::service('entity_type.manager')->getStorage('node_type')->loadMultiple();
        $options = [];

        foreach ($content_types as $content_type) {
          if ($content_type->status()) {
            $options[$content_type->id()] = $content_type->label();
          }
        }
        $form['contenttype'] = [
          '#type' => 'select',
          '#title' => "Content Type",
          '#options' => $options,
          '#default_value' => $config->get("contenttype"),
        ];
        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      // Save all Configuration values.
      $config = $this->config(static::CONFIGNAME);
      $config->set("texttoadd", $form_state->getValue('texttoadd'));
      $config->set("contenttype", $form_state->getValue('contenttype'));
      $config->save();
      // Load all node ids for the selected content type.
      $nids = \Drupal::entityQuery('node')->condition('type',$config->get("contenttype"))->accessCheck(TRUE)->execute();
      // Node Objects.
      $nodes =  Node::loadMultiple($nids);
      // Construct operations for each node. Each node will act as one batch item.
      foreach ($nodes as $k => $node) {
        // Pass node, texttoadd as argument for batch process. You can pass n number of arguments or by array.
        $operations[] = [
          '\Drupal\custom_batch\Form\CustomBatchProcess::UpdateNodes',
          [$node, $config->get("texttoadd")]
        ];
      }
      // Set batch process.
      $batch = [
        'title' => t('Updating Nodes'),
        'operations' => $operations,
        'finished' => '\Drupal\custom_batch\Form\CustomBatchProcess::FinishUpdates',
      ];
      batch_set($batch);
    }

    public static function UpdateNodes($node, $texttoadd, &$context) {
      // Construct title with texttoadd.
      $title = $texttoadd . " " . $node->get('title')->getValue()[0]['value'];
      $node->set('title', $title);
      // Try catch to handle success and failed records.
      try {
        $node->save();
        // This is to have a track of how many records are successful.
        $context['results']['success'][] = 1;
      }
      catch (\Exception $e) {
        // This is to have a track of how many records are failed.
        $context['results']['failed'][] = 1;
      }
    }

    public static function FinishUpdates($success, $results, $operations) {
      $message = "";
      // If batch is success.
      if ($success) {
        // Construct message to show once finished.
        // formatPlural() will helps you to print message in singular or plural form based upon count.
        if (isset($results['success']) && !empty(($results['success']))) {
          // if you have 5 item success, then the array will be $results['success'] = [1,1,1,1,1].
          $successcount = count($results['success']);
          $message .= \Drupal::translation()->formatPlural(
          $successcount,
          'One record success.', '@count records success. ');
        }
        if (isset($results['failed']) && !empty(($results['failed']))) {
          $failedcount = count($results['failed']);
          $message .= \Drupal::translation()->formatPlural(
          $failedcount,
          'One record failed.', '@count records failed. ');
        }
      }
      else {
        // If batch process is failed.
        $message = t('Finished with an error.');
      }
      \Drupal::messenger()->addMessage($message);
    }

}
