(function ($) {
Drupal.behaviors.msh_calendar = {
  attach: function(context) {
    var $page = $('.page-admin-activities-calendar', context);
        $upcoming_events = $('.page-admin-activities-calendar .view-header .view-display-id-page_2'),
        $cell = $('.view-activity-dates tbody td'),
        count = 0;

    // Add title to Upcoming events
    $upcoming_events.prepend('<h2 class="title"><i class="flaticon-clock"></i>' + Drupal.t('Upcoming events') + '</h2>');

    // Attach base modal element
    $page.prepend('<div class="calendar-modal"><div class="inner"></div></div>');
    var $calendar_modal = $('.calendar-modal');

    // Make for each cell a link to modal
    $cell.each(function(index) {
      count = $('.item', this).length;
      if (count > 0) {
        // Hide items
        $('.item', this).hide();

        // Create modal triggers
        $(this).append('<div class="modal-trigger" id="modal-trigger-' + index +'"></div>');

        var $modal_trigger = $('#modal-trigger-' + index, context),
            cell = this;

        // Fill modal triggers with text
        if (count == '1') {
          $modal_trigger.html(count + ' ' + Drupal.t('event'));
        } else {
          $modal_trigger.html(count + ' ' + Drupal.t('events'));
        }

        // Open modal by click
        $modal_trigger.click(function() {
          openModal($(cell).html(), $('.item', cell).length, $(cell).attr('data-date'));
        });
      }
    });

    // Click anywhere to close modal
    $calendar_modal.click(function() {
      $(this).hide();
    });

    // Make available escape key to close modal
    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        $calendar_modal.hide();
      }
    });

    // Open modal and fill it with appropriate data
    var openModal = function(content, count, events_date) {
      var $modal = $('.calendar-modal');
      // Attach content
      $modal.html(content);
      // Attach header wrapper
      $('.inner', $modal).prepend('<div class="modal-header"></div>');

      // Attach header content
      $('.inner .modal-header', $modal).prepend('<span class="close"></span>');

      // Fill modal header title
      if (count == '1') {
        $('.inner .modal-header', $modal).prepend('<h3 class="modal-title">' + count + ' ' + Drupal.t('event on') + ' ' + events_date + '</h3>');
      } else {
        $('.inner .modal-header', $modal).prepend('<h3 class="modal-title">' + count + ' ' + Drupal.t('events on') + ' ' + events_date + '</h3>');
      }
      
      // Show modal
      $('.inner', $modal).hide();
      $modal.show();
      $('.inner', $modal).slideDown('fast');
    }
  }
}
})(jQuery);