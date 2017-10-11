(function ($, Drupal, drupalSettings) {

    Drupal.behaviors.tb_halloween = {

        attach: function (context, settings) {

            Drupal.TBHalloween = Drupal.TBHalloween || {};
            Drupal.TBHalloween.tb_halloween_path = drupalSettings.tb_halloween.tb_halloween_path;
            Drupal.TBHalloween.tb_halloween_items = {};
            Drupal.TBHalloween.items = Drupal.TBHalloween.items || {};
            Drupal.TBHalloween.items = drupalSettings.tb_halloween.tb_halloween_config;

            console.log(Drupal.TBHalloween.items    );

            $(window).load(function() {
                var items = Drupal.TBHalloween.items;
                for(x in items) {
                    var item = items[x];
                    for(y in item) {
                        var pumpkin = item[y];
                        var options = {
                            id: 'id_' + item['id'] + "_number_" + y,
                            image: pumpkin['image'],
                            width: pumpkin['width'],
                            height: pumpkin['height'],
                            tip: pumpkin['hover_message'],
                            frame: pumpkin['frame'],
                            duration: pumpkin['flying_speed'],
                            fps: pumpkin['swing_speed'],
                            delay: pumpkin['delay_time'],
                            delaystart: pumpkin['delaystart_time'],
                            framestart: pumpkin['start_frame'],
                            closeable: pumpkin['closeable'],
                            'class': pumpkin['extend_class'],
                            type: pumpkin['animation_type']
                        };

                        if (pumpkin['animation_type'] == 'random') {
                            if (pumpkin['animation_area']) {
                                options.data = [pumpkin['area_left'], pumpkin['area_top'], pumpkin['area_right'], pumpkin['are_bottom']];
                            }
                        }
                        else if (pumpkin['animation_type'] == 'preset') {
                            options.data = pumpkin['pos_array'];
                        }

                        new Frame(options);
                    }
                }
            });

            Drupal.TBHalloween.closePumpkin = function(ele) {
                var closed_pumpkins = $.cookie("closed_pumpkin") ? $.cookie("closed_pumpkin") : [];
                closed_pumpkins.push('1');
                $.cookie("closed_pumpkin", array(), {path: "/"});
            }
        }
    };

})(jQuery, Drupal, drupalSettings);
