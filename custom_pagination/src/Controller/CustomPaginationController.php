<?php

namespace Drupal\custom_pagination\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for custom_pagination routes.
 */
class CustomPaginationController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    // For example purpose, I have taken "node" table.
    $query = \Drupal::database()->select('node', 'n');
    $query->fields('n', ['nid', 'type']);
    //For the pagination we need to extend the pagerselectextender and
    //limit in the query
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(3);
    $results = $pager->execute()->fetchAll();
    foreach ($results as $result) {
      // Construct each rows data.
      $rows[] = [
        "data" => [
          $result->nid,
          $result->type,
        ],
      ];
    }
    // Header for the table.
    $header = [
      'nid' => "ID",
      'type' => 'Type',
    ];
    $build['table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No result found'),
    ];
    // Render pagination at the bottom.
    $build['pager'] = array(
      '#type' => 'pager'
    );

    return $build;
  }

}
