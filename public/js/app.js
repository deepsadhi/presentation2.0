$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('file', $(e.relatedTarget).data('file'));
    $('#name').html($(this).find('.btn-ok').attr('file'));

    $(this).find('.btn-ok').attr('file', $(e.relatedTarget).data('file'));
    $('#file').val($(this).find('.btn-ok').attr('file'));

    $(this).find('.btn-ok').attr('path', $(e.relatedTarget).data('path'));
    $('#path').val($(this).find('.btn-ok').attr('path'));
});
