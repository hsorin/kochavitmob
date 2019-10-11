$(document).ready(function() {
    var pass;
    $('#password').blur(function() {
        pass = $(this).val();
        if (pass.length < 6) {
            $('#errorMsg').text('הסיסמה קצרה מידי');
        }
    });

    $('#confirmPassword').blur(function() {
        var confPass = $(this).val();
        if (confPass != pass) {
            $('#errorMsgConf').text('הקלדת סיסמה שונה');
        }
    });
});