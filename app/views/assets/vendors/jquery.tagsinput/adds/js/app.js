jQuery(document).ready(function($) {
  var tags = $('.tags').inputTags({
    
    init: function(elem) {
      $('span', '#events').text('init');
    },
    create: function() {
      $('span', '#events').text('create');
    },
    update: function() {
      $('span', '#events').text('update');
    },
    destroy: function() {
      $('span', '#events').text('destroy');
    },
    selected: function() {
      $('span', '#events').text('selected');
    },
    unselected: function() {
      $('span', '#events').text('unselected');
    },
    autocompleteTagSelect: function(elem) {
      console.info('autocompleteTagSelect');
    }
  });

  $('.tags').inputTags('tags', function(tags) {
    $('.results').empty().html('<strong>Tags:</strong> ' + tags.join(' - '));
  });

  var autocomplete = $('.tags').inputTags('options', 'autocomplete');
  // $('span', '#autocomplete').text(autocomplete.values.join(', '));
});