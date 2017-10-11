<?php

namespace Drupal\tb_halloween;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Pumpkin entities.
 */
class PumpkinListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {

    $header['pumpkin_image'] = $this->t('Image');
    $header['size'] = $this->t('Size');
    $header['hover_message'] = $this->t('Hover message');
    $header['animation_type'] = $this->t('Animation type');
    $header['number_pumpkins'] = $this->t('Number');
    $header['animation_area'] = $this->t('Animation area');
    $header['flying_speed'] = $this->t('Speed');
    $header['swing_speed'] = $this->t('Swing speed');
    $header['delay_time'] = $this->t('Delay');
    $header['delaystart_time'] = $this->t('Delaystart');
    $header['start_frame'] = $this->t('Start frame');
    $header['closeable'] = $this->t('Closeable');
    $header['preset'] = $this->t('Preset');
    $header['custom_preset'] = $this->t('Custom preset');
    $header['extend_class'] = $this->t('Css class');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {

    $row['pumpkin_image'] = $entity->get('pumpkin_image');
    $row['size'] = $entity->get('size');
    $row['hover_message'] = $entity->get('hover_message');
    $row['animation_type'] = $entity->get('animation_type');
    $row['number_pumpkins'] = $entity->get('number_pumpkins');
    $row['animation_area'] = $entity->get('animation_area');
    $row['flying_speed'] = $entity->get('flying_speed');
    $row['swing_speed'] = $entity->get('swing_speed');
    $row['delay_time'] = $entity->get('delay_time');
    $row['delaystart_time'] = $entity->get('delaystart_time');
    $row['start_frame'] = $entity->get('start_frame');
    $row['closeable'] = $entity->get('closeable');
    $row['preset'] = $entity->get('preset');
    $row['custom_preset'] = $entity->get('custom_preset');
    $row['extend_class'] = $entity->get('extend_class');

    // You probably want a few more properties here...
    return $row + parent::buildRow($entity);
  }

}
