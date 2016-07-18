(function ($) {
Drupal.behaviors.msh_adminimal_navbar = {
  attach: function(context) {
    $('.navbar-burger-menu').click(function() {
      $('#navbar-administration').show();
      $('#navbar-item-tray').addClass('navbar-active');
      $('body').addClass('navbar-tray-open').addClass('navbar-fixed');
    });
  }
}
})(jQuery);