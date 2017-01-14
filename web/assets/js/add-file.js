$('#uploadModal').find('form').validate({
    rules: {
        'content': {
            required: true,
            checkFileType: true
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
    messages: {
        'content': {
            required: "请选择上传文件"
        },
        'title': {
            required: "标题不能为空"
        },
        'topic': {
            required: "主题不能为空"
        },
        'tag': {
            required: "标签不能为空"
        }
    },
    submitHandler:function(){
        var url = $('#uploadModal').find('form').attr('action');
        var tag = $('[name = tag]').val();
        var file = new FormData($('#uploadModal').find('form')[0]);
        file.append('tag',tag);
        $.ajax({
            url:url,
            cache:false,
            data:file,
            type:"POST",
            async:false,
            processData:false,
            contentType:false,
            success:function(data){
            location.reload();
            },
            error:function(jqXHR){
                alert("添加失败！");
            }
        })
    }
});

jQuery.validator.addMethod("checkFileType", function(value, element) {
    var filepath=$("#inputfile").val();

    //获得上传文件名

    var fileArr=filepath.split("\\");

    var fileTArr=fileArr[fileArr.length-1].toLowerCase().split(".");

    var filetype=fileTArr[fileTArr.length-1];
    //切割出后缀文件名

    if(filetype == "doc" || filetype == 'txt'){
        return true;
    }else{
        return false;
    }

}, "上传文件支持doc和txt");