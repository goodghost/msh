/**
 * @file
 * This function will fire an event after the window resize reach end.
 * How to use it?
 * Simply create a new function in a new file like so: 
 *
 * function helloworld() {
 *   console.log('Hello World!');
 * }
 *
 * And run it as follow: Drupal.behaviors.resizing(helloworld);
 * It will be run once when the page is loaded and every other time when window has changed size.
 */
(function ($) {
  Drupal.behaviors.resizing = function(resizingFunction) {
    var resizeId;
    resizingFunction();
    $(window).resize(function() {
      clearTimeout(resizeId);
      resizeId = setTimeout(resizingFunction, 500);
    });
  }
})(jQuery);