<?php

namespace Drupal\tb_halloween\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class TBHalloweenConfigurationForm extends ConfigFormBase {

  public function getFormId() {
    return 'tb_halloween_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {

    return [
      'tb_halloween.settings',
    ];

  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('tb_halloween.settings');

    $form['path']['tb_halloween_patterns'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Paths'),
      '#default_value' => $config->get('tb_halloween_patterns'),
      '#description' => $this->t('New line separated paths that must start with a leading slash. Wildcard character is *. E.g. /comment/*/reply.'),
    );

    return parent::buildForm($form, $form_state);

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = \Drupal::service('config.factory')->getEditable('tb_halloween.settings');
    $config->set('tb_halloween_patterns', $form_state->getValue('tb_halloween_patterns'));
    $config->set('skip_admin_paths', $form_state->getValue('skip_admin_paths'));
    $config->save();
    drupal_set_message(t('tb_halloween configuration were saved'));
    parent::buildForm($form, $form_state);

  }

}
