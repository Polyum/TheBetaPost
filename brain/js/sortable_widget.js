$(document).ready(function () {
  $(function() {
      $('#sortable_widget').sortable({
          axis: 'y',
         revert: 50,
         tolerance: 'pointer',
         cursor: 'move',
          opacity: 0.7,
          handle: 'span',
          update: function(event, ui) {
              var list_sortable = $(this).sortable('toArray').toString();
          // change order in the database using Ajax
              $.ajax({
                  url: 'set_order_widget.php',
                  type: 'POST',
                  data: {list_order:list_sortable},
                  success: function(data) {
                      //finished
                  }
              });
          }
      }); // fin sortable
  });
});
