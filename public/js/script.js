$( '.see-more > button' ).click(function() {
  $( this ).parent().siblings( '.hidden' ).removeClass( 'hidden' );
  $( this ).addClass( 'hidden' );
});

$( '.create-poll' ).click(function() {
  window.open('/admin/new', '_self')
});

$( '.modify-button' ).click(function() {
  poll = $( '.modify-select' ).val();
  $( '.modify-form' ).attr('action', '/admin/' + poll);
  $( '.modify-form' ).attr('method', 'get');
  $( '.modify-form' ).submit();
});

$( '.delete-button' ).click(function(){
  poll = $( '.modify-select' ).val();
  $( '.modify-form' ).attr('action', '/admin/poll/' + poll);
  /***** method spoofing ******/
  $('.modify-form').append(
    '<input type="hidden" name="_method" value="DELETE">'
  );
  $( '.modify-form' ).submit();
});
