<?php


namespace Drupal\modal_node\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;


class ModalNodeController extends ControllerBase {

  public function modal_node($nid) {

    if (!empty($nid) && is_numeric($nid)) {
      $nodes = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      $title = $nodes->label();
      $build = \Drupal::entityTypeManager()->getViewBuilder('node')->view(
        $nodes,
        'full'
      );
    }

    if (!isset($build)) {
      $build = $this->t('Nothing to show.');
    }

    $options = [
      'dialogClass' => 'popup-dialog-class',
      'width' => '80%',
    ];

    $response = new AjaxResponse();
    $response->addCommand(
      new OpenModalDialogCommand($title . $js, $build, $options)
    );
    return $response;
  }
}