var url = $('#uploadModal').find('form').data('url');
$('#uploadModal').find('form').validate({
    rules: {
        'content': {
            required: true
        },
        'title': {
            required: true
        },
        'topic': {
            required: true
        },
        'tag': {
            required: true
        },
    }
});

$('button[data-toggle="submit"]').on('click',function(){
    $($(this).data('target')).submit();
})