/* Show data of the selected question (the first)
 * in modify poll page,after the loadpage
 */
$( document ).ready(function() {
  id = $( '.poll-select' ).val();
  $( '#' + id + '.modify-question' ).removeClass('hidden');
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
  $('#' + id + '.modify-question' ).removeClass('hidden');
  $( '.form-edit' ).addClass('hidden');
});


/*********** Edit poll_name **************/
$( '.poll > .edit' ).click(function() {
  poll_text = $( '.poll h1' ).text();
  poll_id = $( '.poll' ).attr('id');
  edit('/admin/poll/' + poll_id, 'Change poll title:', poll_text);
});


/************ Add new question ***********/
$( '.poll > .add-question').click(function() {
  add('/admin/question/new', 'New question text', 'question');
});

/************** Edit question **************/
$( '.question > .edit' ).click(function() {
  question_id = $( this ).parent().attr('id');
  question_text = $( '.question#' + question_id + ' h1').text();
  url = '/admin/question/' + question_id
  edit(url, 'Change question text:', question_text, 'question');
});

/* Add new option */
$( '.question > .add-option' ).click(function() {
    add('/admin/option/new', 'New option text', 'option');
});

/**** Delete question ****/
$( '.question > .trash' ).click(function() {
  ques_id = $( this ).parent().attr('id');
  $( '.form-delete' ).attr('action', '/admin/question/' + ques_id);
  $( '.submit-delete-btn' ).trigger( "click" );
});

/**** Edit option ****/
$( '.option > .edit ' ).click(function() {
  option_id = $( this ).parent().attr('id');
  option_text = $( '.option#' + option_id + ' p').text();
  edit('/admin/option/' + option_id, 'Change option text:', option_text)
});

/* Delete option */
$( '.option > .trash ' ).click(function() {
  option_id = $( this ).parent().attr('id');
  $( '.form-delete' ).attr('action', '/admin/option/' + option_id);
  $( '.submit-delete-btn' ).trigger( "click" );
});

/* Hide form when user clicks cancel button */
$( '.cancel-edit' ).click(function() {
  $( '.form-edit' ).addClass('hidden');
});

$( '.cancel-add' ).click(function() {
  $( '.form-add' ).addClass('hidden');
});

/* function for editing polls questions and options' names */
function edit(url, label_text, placeholder, type) {
  $( '.form-add' ).addClass('hidden');
  $( '.form-edit' ).removeClass('hidden');
  $( '.form-edit' ).attr('action', url);
  $( '.label-edit' ).text(label_text);
  $( '#edit-text' ).attr('placeholder', placeholder);
  if(type === 'question') {
    $( '.edit-ques-type' ).removeClass('hidden');
    $( '.edit-ques-type select' ).prop('disabled', false);
  } else {
    $( '.edit-ques-type' ).addClass('hidden');
    $( '.edit-ques-type select' ).prop('disabled', true);
  }
}

function add(url, label_text, type) {
  $( '.form-edit' ).addClass('hidden');
  $( '.form-add' ).removeClass('hidden');
  $( '.form-add' ).attr('action', url);
  $( '.label-add' ).text(label_text);
  if(type === 'question') {
    $( '.add-ques-type' ).removeClass('hidden');
    $( '.add-ques-type select' ).prop('disabled', false);
  } else {
    $( '.add-ques-type' ).addClass('hidden');
    $( '.add-ques-type select' ).prop('disabled', true);
  }
}
