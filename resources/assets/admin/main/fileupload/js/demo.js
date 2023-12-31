$(function () {
  'use strict';
  $('#fileupload').fileupload({
    url: window.location.origin+'/resources/assets/admin/main/fileupload/php/'
  });

  $('#fileupload').addClass('fileupload-processing');

  $.ajax({
    url: $('#fileupload').fileupload('option', 'url'),
    dataType: 'json',
    context: $('#fileupload')[0]
  })
  .always(function () {
    $(this).removeClass('fileupload-processing');
  })
  .done(function (result) {
    $(this).fileupload('option', 'done').call(this, $.Event('done'), { result: result });
  });
});
