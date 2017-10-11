<?php

namespace Drupal\tb_halloween\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\Markup;

/**
 * Class PumpkinForm.
 */
class PumpkinForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);
    $pumpkin = $this->entity;
    $form['#attached']['library'][] = 'tb_halloween/tb_halloween_config';

    $current_pumpkin_image = $pumpkin->get('pumpkin_image');
    $current_size = $pumpkin->get('size');
    $current_hover_message = $pumpkin->get('hover_message');
    $current_animation_type = $pumpkin->get('animation_type');
    $current_number_pumpkins = $pumpkin->get('number_pumpkins');
    $current_animation_area = $pumpkin->get('animation_area');
    $current_flying_speed = $pumpkin->get('flying_speed');
    $current_swing_speed = $pumpkin->get('swing_speed');
    $current_delay_time = $pumpkin->get('delay_time');
    $current_delaystart_time = $pumpkin->get('delaystart_time');
    $current_start_frame = $pumpkin->get('start_frame');
    $current_closeable = $pumpkin->get('closeable');
    $current_preset = $pumpkin->get('preset');
    $current_custom_preset = $pumpkin->get('custom_preset');
    $current_extend_class = $pumpkin->get('extend_class');

    $default_item = tb_halloween_default_pumpkin();
    $item = $item ? $pumpkin->get('pumpkin_image') : $default_item;

    $thumbs = tb_halloween_get_thumbs();

    $images_select = array();

    $images_select[] = '<div class="form-item form-type-select form-item-image"><label for="edit-image">';
    $images_select[] = t('Select Image');
    $images_select[] = '<span title="This field is required." class="form-required">*</span></label><div class="form-select required" name="image" id="edit-image">';

    foreach ($thumbs as $key => $detail) {
      $selected = ((!$pumpkin->get('pumpkin_image') && $key == 'pumpkin') || $key == $pumpkin->get('pumpkin_image') ? 'selected' : '');
      $images_select[] = '<a href="javascript:void(0)" class="' . $selected . '" onclick="Drupal.TBHalloween.selectImage(this);"><img src="' . tb_halloween_get_thumb($key, 'default') . '"/><input type="hidden" name="select-image" value="' . $key . '"/></a>';
    }

    $images_select[] = '</div>';
    $images_select[] = '<div class="description">';
    $images_select[] = t('Select the image for your animation.');
    $images_select[] = '</div>';
    $images_select[] = '</div>';

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $pumpkin->label(),
      '#description' => $this->t("Label for the Pumpkin."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $pumpkin->id(),
      '#machine_name' => [
        'exists' => '\Drupal\tb_halloween\Entity\Pumpkin::load',
      ],
      '#disabled' => !$pumpkin->isNew(),
    ];

    $form["select-image"] = array(
      '#markup' => Markup::create(implode("", $images_select)),
    );

    $form['pumpkin_image'] = [
      '#type' => 'hidden',
      '#default_value' => isset($current_pumpkin_image) ? $current_pumpkin_image : $default_item->pumpkin_image,
      '#required' => TRUE,
    ];

    $form['size'] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Image Size"),
      '#description' => t('Set the size of the image.'),
      '#options' => tb_halloween_sizes_options(),
      '#default_value' => isset($current_size) ? $current_size : $default_item->size,
    );

    $form["hover_message"] = array(
      '#type' => 'textarea',
      '#required' => TRUE,
      '#title' => t("Message"),
      '#description' => t('Message which will be displayed when you hover the image. You can use HTML, too.'),
      '#default_value' => isset($current_hover_message) ? $current_hover_message : $default_item->hover_message,
    );

    $form['number_pumpkins'] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Number of Instances"),
      '#description' => t('Select whether you want to have more than 1 animation instance of the same image.'),
      '#options' => tb_halloween_number_pumpkins_options(),
      '#default_value' => isset($current_number_pumpkins) ? $current_number_pumpkins : $default_item->number_pumpkins,
    );

    $form["animation_type"] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Animation Type"),
      '#description' => t("Select from 2 defined animation types.<br>(1) <strong>Random</strong>: The image will follow random positions.<br>(2) <strong>Path</strong>: The image follows a predefined animation path."),
      '#options' => tb_halloween_animation_types_options(),
      '#default_value' => isset($current_animation_type) ? $current_animation_type : $default_item->animation_type,
    );

    $form["presets_wrapper"] = array(
      '#type' => 'container',
      '#required' => TRUE,
      '#states' => array(
        'visible' => array(
          'select[name="animation_type"]' => array(
            'value' => 'preset',
          ),
        ),
      ),
    );

    $form["presets_wrapper"]['preset'] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Path"),
      '#options' => tb_halloween_presets_options(),
      '#default_value' => isset($current_preset) ? $current_preset : $default_item->preset,
      '#description' => t("Select from a set of pre-defined paths or create your custom animation path."),
    );

    $form["presets_wrapper"]["custom_preset_wrapper"] = array(
      '#type' => 'container',
      '#required' => TRUE,
      '#states' => array(
        'visible' => array(
          'select[name="preset"]' => array(
            'value' => 'custom_preset',
          ),
        ),
      ),
    );

    $form["presets_wrapper"]["custom_preset_wrapper"]['custom_preset'] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => t("Custom Path"),
      '#default_value' => isset($current_custom_preset) ? $current_custom_preset : $default_item->custom_preset,
      '#description' => t("Define your custom animation path. Add path coordinates as followed x1, y1, x2, y2, x3, y3, ..."),
    );

    $form["random_wrapper"] = array(
      '#type' => 'container',
      '#required' => TRUE,
      '#states' => array(
        'visible' => array(
          'select[name="animation_type"]' => array(
            'value' => 'random',
          ),
        ),
      ),
    );

    $form["random_wrapper"]["animation_area"] = array(
      '#type' => 'textfield',
      '#title' => t("Animation Area"),
      '#description' => t('Defines a rectangular boundry area with 4 coordinates "Left, Top, Right, Bottom". The animation is limited to this area. If you leave it empty the full viewport will be used.'),
      '#value' => isset($current_animation_area) ? $current_animation_area : $default_item->animation_area,
      '#default_value' => isset($current_animation_area) ? $current_animation_area : $default_item->animation_area,
    );

    $form["flying_speed"] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Animation Speed"),
      '#description' => t("Select the pre-defined animation speed. Default, Fast, Slow."),
      '#options' => tb_halloween_get_flying_speed_options(),
      '#default_value' => isset($current_flying_speed) ? $current_flying_speed : $default_item->flying_speed,
    );

    $form["swing_speed"] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Wing speed"),
      '#description' => t("Select from Default, Slow, Fast to set the wing speed."),
      '#options' => tb_halloween_get_swing_speed_options(),
      '#default_value' => isset($current_swing_speed) ? $current_swing_speed : $default_item->swing_speed,
    );

    $form["delay_time"] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => t("Pause Time"),
      '#description' => t("On the animation path the image will pause. You can set the pausing time of the animation."),
      '#default_value' => isset($current_delay_time) ? $current_delay_time : $default_item->delay_time,
    );

    $form["delaystart_time"] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => t("Delay Time"),
      '#description' => t("Animation will start after your defined delay time (ms)."),
      '#default_value' => isset($current_delaystart_time) ? $current_delaystart_time : $default_item->delaystart_time,
    );

    $form["start_frame"] = array(
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => t("Start Frame"),
      '#description' => t("The animation is set in frames e.g. 45 frames/second. Set the frame number which you want the animation to start with. In case you have more than 1 animation this would be an option to display delayed frames for each flying image (to avoid synchronized animation). It will look more chaotic ;)"),
      '#default_value' => isset($current_start_frame) ? $current_start_frame : $default_item->start_frame,
    );

    $form["closeable"] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t("Closeable"),
      '#options' => tb_halloween_closeable_options(),
      '#description' => t("Allow user to remove the animated images at the front-end."),
      '#default_value' => isset($current_closeable) ? $current_closeable : $default_item->closeable,
    );

    $form["extend_class"] = array(
      '#type' => 'textfield',
      '#title' => t("Custom CSS class"),
      '#description' => t("Add your custom CSS class to write custom styles."),
      '#default_value' => isset($current_extend_class) ? $current_extend_class : $default_item->extend_class,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $pumpkin = $this->entity;
    $status = $pumpkin->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Pumpkin.', [
          '%label' => $pumpkin->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Pumpkin.', [
          '%label' => $pumpkin->label(),
        ]));
    }
    $form_state->setRedirectUrl($pumpkin->toUrl('collection'));
  }

}
