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
  $( '.spoofing' ).attr('value', 'GET');
  $( '.submit-btn').trigger('click');
});

$( '.delete-button' ).click(function(){
  poll = $( '.modify-select' ).val();
  $( '.modify-form' ).attr('action', '/admin/poll/' + poll);
  //method spoofing
  $('spoofing').attr('value', 'DELETE');
  $( '.submit-btn' ).trigger('click');
});
/*******************************************************/


/* Show the data of the selected question in modify-poll page */
$( '.poll-select' ).change(function() {
  $( ' .modify-question ' ).addClass('hidden');
  id = $( '.poll-select' ).val();
  $( '.modify-question#' + id ).removeClass('hidden');
  $( '.form-edit' ).addClass('hidden');
});


/*********** Edit poll_name **************/
$( '.poll > .edit' ).click(function() {
  poll_text = $( '.poll h1' ).text();
  poll_id = $( '.poll' ).attr('id');
  edit('/admin/poll/' + poll_id, 'New poll title:', poll_text);
});



$( '.poll > .add').click(function() {
  alert("add a new question");
});


$( '.question > .edit' ).click(function() {
  question_id = $( this ).parent().attr('id');
  question_text = $( '.question#' + question_id + ' h1').text();
  edit('/admin/question/' + question_id, 'New question text:', question_text);
});

$( '.question > .add' ).click(function() {
  alert("add option");
});

/**** Delete question ****/
$( '.question > .trash' ).click(function() {
  ques_id = $( this ).parent().attr('id');
  $( '.form-delete' ).attr('action', '/admin/question/' + ques_id);
  $( '.submit-delete-btn' ).trigger( "click" );
});

$( '.option > .edit ' ).click(function() {
  option_id = $( this ).parent().attr('id');
  option_text = $( '.option#' + option_id + ' p').text();
  edit('/admin/option/' + option_id, 'New option text:', option_text)
});

$( '.option > .trash ' ).click(function() {
  option_id = $( this ).parent().attr('id');
  $( '.form-delete' ).attr('action', '/admin/option/' + option_id);
  $( '.submit-delete-btn' ).trigger( "click" );
});

/* Hide form when user clicks cancel button */
$( '.cancel-edit' ).click(function() {
  $( '.form-edit' ).addClass('hidden');
});

/* function for editing polls questions and options' names */
function edit(url, label_text, placeholder) {
  $( '.form-edit' ).removeClass('hidden');
  $( '.form-edit' ).attr('action', url);
  $( '.label-edit' ).text(label_text);
  $( '#edit-text' ).attr('placeholder', placeholder);
}
