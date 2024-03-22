$(document).ready(function(){
    $('#update-form').submit(function(e){
        e.preventDefault();
        var newEmail = $('#new_email').val();
        var newName = $('#new_name').val();
        var newDob = $('#new_dob').val();
        
        $.ajax({
            url: 'php/profile.php',
            method: 'POST',
            data: {new_email: newEmail, new_name: newName, new_dob: newDob},
            success: function(response){
                alert(response);
                location.reload();
            }
        });
    });
});
