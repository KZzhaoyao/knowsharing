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