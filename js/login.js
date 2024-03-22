$(document).ready(function(){
    $('#login-form').submit(function(e){
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        
        $.ajax({
            url: '..php/login.php',
            method: 'POST',
            data: {email: email, password: password},
            success: function(response){
                if(response === 'success'){
                    window.location.href = 'profile.html';
                } else {
                    $('#error-messages').html('<div class="alert alert-danger">'+response+'</div>');
                }
            }
        });
    });
});


