<?php

namespace Drupal\tb_halloween\Controller;

class TBHalloweenConfigurationController
{

  public function configure() {

    $form = \Drupal::formBuilder()
      ->getForm('Drupal\tb_halloween\Form\TBHalloweenConfigurationForm');
    return $form;
  }
}