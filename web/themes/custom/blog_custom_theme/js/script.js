/* script.js */
(function ($, Drupal) {
  Drupal.behaviors.myCustomBehavior = {
    attach: function (context, settings) {
      console.log("My Custom Theme JavaScript Loaded.");
    },
  };
})(jQuery, Drupal);
