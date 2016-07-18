(function ($) {
Drupal.behaviors.msh_adminimal = {
  attach: function(context) {

    // Search form focus and blur actions
    var $search = $('.search-block'),
        $submit_search = $('.search-form input.form-submit', $search),
        $form_text_item = $('.search-form .form-item', $search).not('.tabbable .form-type-textfield'),
        $group = $('.top-bar .right .navbar-burger-menu, .top-bar .right .logout, .top-bar .right .user-data, .top-bar .right .events');

    $('label', $form_text_item).hide();
    $submit_search.hide();
    
    $form_text_item.each(function(index) {
      var value = $('label', this).text();
      $('input', this).val(value);

      $('input', this).focus(function() {
        $(this).val('');
        $submit_search.show();
      });

      $('input', this).blur(function() {
        if ($(this).val() == '') {
          $(this).val(value);
          $submit_search.hide();
        }
      });
    });

    enquire.register('screen and (max-width:' + Drupal.settings.msh_adminimal.tablet[1]+ 'px)', {
      // OPTIONAL
      // If supplied, triggered when a media query matches.
      match : function() {
        $('form.search-form').hide();
        $('i.flaticon', $search).click(function() {
          if ($group.parent()[0].className != 'responsive-line') {
            $group.wrapAll('<div class="responsive-line"></div>');
          }
          $('form.search-form').show();
        });
      },      
                                  
      // OPTIONAL
      // If supplied, triggered when the media query transitions 
      // *from a matched state to an unmatched state*.
      unmatch : function() {
        $('form.search-form').show();
        $('i.flaticon', $search).unbind('click');
        if ($group.parent()[0].className == 'responsive-line') {
          $group.unwrap();
        }
      },    
      
      // OPTIONAL
      // If supplied, triggered once, when the handler is registered.
      setup : function() {},    
                                  
      // OPTIONAL, defaults to false
      // If set to true, defers execution of the setup function 
      // until the first time the media query is matched
      deferSetup : true,
                                  
      // OPTIONAL
      // If supplied, triggered when handler is unregistered. 
      // Place cleanup code here
      destroy : function() {}
        
    }); 
    
    Drupal.behaviors.resizing(exposed_filters_submit_height);

    // Submit wrapper - exposed filters
    function exposed_filters_submit_height() { 
      var $submit = $('#main-content .view .views-exposed-form .views-exposed-widget.views-submit-button'),
          $exposed_form = $('#main-content .view .views-exposed-form');
      
      $exposed_form.append($submit);

      var $views_exposed_widgets = $('.views-exposed-widgets', $exposed_form);
      $views_exposed_widgets.css({'height' : 'auto'});
      var views_exposed_widgets_height = $views_exposed_widgets.outerHeight();

      $('.views-exposed-widget.views-submit-button', $exposed_form).height(views_exposed_widgets_height);
    }

    // Hide tabs-secondary and #navigation if theres no li items
    var $navigation = $('#navigation');
    var primary = $('.tabs.primary', $navigation).find('li');
    var secondary = $('.tabs.secondary', $navigation).find('li');
    if (primary.length == '0' && secondary.length == '0') {
      $navigation.hide();
    }
    
    // Height of fieldset in inline entity form
    var $fieldset = $('body #page #content #main-content .node-form .field-widget-inline-entity-form fieldset.modal-ief .fieldset-wrapper .field-group-htabs-wrapper .horizontal-tabs-panes fieldset.horizontal-tabs-pane, body #page #content #main-content .node-form .field-widget-inline-entity-form .fieldset-wrapper .field-group-htabs-wrapper .horizontal-tabs-panes fieldset.horizontal-tabs-pane'),
        fieldset_height = $fieldset.outerHeight();

    $fieldset.height(fieldset_height - 60);

    // Default date placeholder text in exposed filters
    $('[name="field_person_booking_date_value[min][date]"]').attr('placeholder', Drupal.t("from"));
    $('[name="field_person_booking_date_value[max][date]"]').attr('placeholder', Drupal.t("to"));

    $('[name="field_activity_dates_value[min][date]"]').attr('placeholder', Drupal.t("from"));
    $('[name="field_activity_dates_value[max][date]"]').attr('placeholder', Drupal.t("to"));

    $('[name="field_price_amount[min]"]').attr('placeholder', Drupal.t("from"));
    $('[name="field_price_amount[max]"]').attr('placeholder', Drupal.t("to"));
  }
}
})(jQuery);