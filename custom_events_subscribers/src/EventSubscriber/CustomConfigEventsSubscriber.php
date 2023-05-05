<?php

namespace Drupal\custom_events_subscribers\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;

class CustomConfigEventsSubscriber implements EventSubscriberInterface {
    /**
   * {@inheritdoc}
   *
   * @return array
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = ['configSave', -100];
    $events[ConfigEvents::SAVE][] = ['configDelete', 100];
    return $events;
    }

    public function configSave(ConfigCrudEvent $event) {
        $config = $event->getConfig();
        \Drupal::messenger()->addStatus('Saved config: ' . $config->getName());
      }

      public function configDelete(ConfigCrudEvent $event) {
        $config = $event->getConfig();
        \Drupal::messenger()->addStatus('Deleted config: ' . $config->getName());
      }

}
