console.log($('#uploadModal').find('form'));
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
        }
    },
    submitHandler:function(){
        var url = $('#uploadModal').find('form').attr('action');
        var content = $('[name = content]').val();
        var title = $('[name = title]').val();
        var type = $('[name = type]').val();
        var summary = $('[name = summary]').val();
        var topic = $('[name = topic]').val();
        var tag = $('[name = tag]').val();
        $.post(url, {content:content,title:title,type:type,summary:summary,topic:topic,tag:tag}, function(data){
            location.reload();
        });
    }
});