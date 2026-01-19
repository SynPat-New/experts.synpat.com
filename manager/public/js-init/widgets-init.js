/* Prevent default on # hrefs */

$(function() { "use strict";
  $('a[href="#"]').click(function(event) {
      event.preventDefault();
  });
});

/* To do check toggle */
$(function() { "use strict";
  $(".todo-box li input").on('click', function() {
      $(this).parent().toggleClass('todo-done');
  });
});
/* Loading buttons */

$(function() { "use strict";

  $('.loading-button').click(function() {
      var btn = $(this)
      btn.button('loading');
  });

});