$('.see-more > button').click(function() {
  $( this ).parent().siblings('.hidden').removeClass('hidden');
  $( this ).addClass('hidden');
});