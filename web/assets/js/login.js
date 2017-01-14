    $('#login-check').validate({
        rules: {
            '_username': {
                required: true
            },
            '_password': {
                required: true
            }
        },
    messages: {
        '_username': {
            required: "用户名不能为空"
        },
        '_password': {
            required: "密码不能为空"
        }
    }
    });

    $('#register-check').validate({
        rules: {
            'username': {
                required: true,
            remote: {
                url: "/login/check/user/name",     //后台处理程序
                type: "get",               //数据发送方式
                dataType: "json",
                data: {                     //要传递的数据
                    number: function() {
                        return $("#register-name").val();
                    }
                }
            }
            },
            'password': {
                required: true,
                checkPassWord: true
            }
        },
    messages: {
        'username': {
            required: "用户名不能为空",
            remote: "该用户名已存在"
        },
        'password': {
            required: "密码不能为空"
        }
    }
    });

jQuery.validator.addMethod("checkPassWord", function(value, element) { 
    return this.optional(element) || (/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,10}$/.test(value));    
}, "请输入6-10位字母数字组合");