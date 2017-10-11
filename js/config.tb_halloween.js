(function ($) {

    Drupal.TBHalloween = Drupal.TBHalloween || {};

    Drupal.TBHalloween.selectImage = function(element) {
        $('input[name="pumpkin_image"]').val($(element).find('input[type="hidden"]').val());
        $(element).parent().children().removeClass('selected');
        $(element).addClass('selected');
    };

})(jQuery);
