$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('name', $(e.relatedTarget).data('name'));

    $('#name').html($(this).find('.btn-ok').attr('name'));

    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $('#delete-form').attr("action", $(this).find('.btn-ok').attr('href'));
});
