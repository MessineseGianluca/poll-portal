/* Show data of the selected question (the first)
 * in modify poll page,after the loadpage
 */
$( document ).ready(function() {
  id = $( '.poll-select' ).val();
  $( '.modify-question#' + id ).removeClass('hidden');
});

/* Handle the 'see more' button for the opened questions */
$( '.see-more > button' ).click(function() {
  $( this ).parent().siblings( '.hidden' ).removeClass( 'hidden' );
  $( this ).addClass( 'hidden' );
});

/* Handle the new-poll button in /Admin */
$( '.create-poll' ).click(function() {
  window.open('/admin/new', '_self')
});


/********************* DELETE AND MODIFY FORM IN /Admin *******************/
$( '.modify-button' ).click(function() {
  poll = $( '.modify-select' ).val();
  $( '.modify-form' ).attr('action', '/admin/' + poll);
  $( '.modify-form' ).attr('method', 'get');
  $( '.modify-form' ).submit();
});

$( '.delete-button' ).click(function(){
  poll = $( '.modify-select' ).val();
  $( '.modify-form' ).attr('action', '/admin/poll/' + poll);
  //method spoofing
  $('.modify-form').append(
    '<input type="hidden" name="_method" value="DELETE">'
  );
  $( '.modify-form' ).submit();
});
/*******************************************************/


/* Show the data of the selected question in modify-poll page */
$( '.poll-select' ).change(function() {
  $( ' .modify-question ' ).addClass('hidden');
  id = $( '.poll-select' ).val();
  $( '.modify-question#' + id ).removeClass('hidden');
});


$( '.poll > .edit' ).click(function() {
  alert("edit poll");
});

$( '.poll > .add').click(function() {
  alert("add a new question");
});


$( '.question > .edit' ).click(function() {
  alert("edit question");
});

$( '.question > .add' ).click(function() {
  alert("add option");
});

$( '.question > .trash' ).click(function() {
  alert("delete question");
});

$( '.option > .edit ' ).click(function() {
  alert("edit option");
});

$( '.option > .trash ' ).click(function() {
  alert("delete option");
});
