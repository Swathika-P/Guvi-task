$('#register-btn').click(function(e){
    e.preventDefault();
    var fullname = $('#fullname').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var repeatPassword = $('#repeat_password').val();
    
    $.ajax({
        url: 'php/register.php',
        method: 'POST',
        data: {fullname: fullname, email: email, password: password, repeat_password: repeatPassword},
        success: function(response){
            var data = JSON.parse(response);
            if(data.status == 'success'){
                $('#success-message').html('<div class="alert alert-success">'+data.message+'</div>');
            } else {
                $('#error-messages').html('');
                data.errors.forEach(function(error){
                    $('#error-messages').append('<div class="alert alert-danger">'+error+'</div>');
                });
            }
        }
    });
});
