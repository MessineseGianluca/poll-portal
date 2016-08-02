$( '.see-more > button' ).click(function() {
  $( this ).parent().siblings( '.hidden' ).removeClass( 'hidden' );
  $( this ).addClass( 'hidden' );
});

$( '.create-poll' ).click(function() {
  window.open('/admin/new', '_self')
});

$( '.modify-button' ).click(function() {
  poll = $( '.modify-select' ).val();
  console.log(poll);
  $( '.modify-form' ).attr('action', '/admin/' + poll);
  $( '.modify-form' ).submit();
});
