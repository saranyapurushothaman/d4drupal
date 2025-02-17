<?php

namespace Drupal\custom_node_action\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides an Update Node Title Action.
 *
 * @Action(
 *   id = "update_node_title",
 *   label = @Translation("Update Node Title"),
 *   type = "node",
 *   category = @Translation("Custom")
 * )
 */
class UpdateNodeTitle extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function access($node, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\node\NodeInterface $node */
    $access = $node->access('update', $account, TRUE)
      ->andIf($node->title->access('edit', $account, TRUE));
    return $return_as_object ? $access : $access->isAllowed();
  }

  /**
   * {@inheritdoc}
   */
  public function execute($node = NULL) {
    $title = $node->getTitle();
    // $old_alias = $node->path->alias;
    $new_title = $this->t('New Title @title', ['@title' => $title]);
    $node->setTitle($new_title);

    $node->save();

  }
}
