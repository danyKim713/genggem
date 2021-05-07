var showModal = function (target) {
  $('html').addClass('remodal-is-locked');
  $('.overlay').addClass('overlay-show');
  $('#' + target + '').removeClass('hidden');
}

var hideModal = function () {
  $('html').removeClass('remodal-is-locked');
  $('.overlay').removeClass('overlay-show');
  $('.remodal').addClass('hidden');
}

$(function () {
  $("[data-toggle='golfen-modal']").on('click', function (evt) {
    var target = $(this).data('id');
    showModal(target);
  });
});
