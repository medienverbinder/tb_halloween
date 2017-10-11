<?php

namespace Drupal\tb_halloween\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Pumpkin entity.
 *
 * @ConfigEntityType(
 *   id = "pumpkin",
 *   label = @Translation("Pumpkin"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\tb_halloween\PumpkinListBuilder",
 *     "form" = {
 *       "add" = "Drupal\tb_halloween\Form\PumpkinForm",
 *       "edit" = "Drupal\tb_halloween\Form\PumpkinForm",
 *       "delete" = "Drupal\tb_halloween\Form\PumpkinDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\tb_halloween\PumpkinHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "pumpkin",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/media/tb_halloween/pumpkin/{pumpkin}",
 *     "add-form" = "/admin/config/media/tb_halloween/pumpkin/add",
 *     "edit-form" = "/admin/config/media/tb_halloween/pumpkin/{pumpkin}/edit",
 *     "delete-form" = "/admin/config/media/tb_halloween/pumpkin/{pumpkin}/delete",
 *     "collection" = "/admin/config/media/tb_halloween/pumpkin"
 *   }
 * )
 */
class Pumpkin extends ConfigEntityBase implements PumpkinInterface {

  /**
   * The Pumpkin ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Pumpkin label.
   *
   * @var string
   */
  protected $label;

  public $pumpkin_image;
  public $size;
  public $hover_message;
  public $animation_type;
  public $number_pumpkins;
  public $animation_area;
  public $flying_speed;
  public $swing_speed;
  public $delay_time;
  public $delaystart_time;
  public $start_frame;
  public $closeable;
  public $preset;
  public $custom_preset;
  public $extend_class;

}
