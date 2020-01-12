// Gets data from the login form and sends it to 'login.php'
// If data is returned, an error will appear on the modal.
// If data is not returned, the user is logged in and the page reloads.
$(document).ready(function () {
    $('#login-form').on('submit', function (event) {
        event.preventDefault(); // prevents the form from sending it's own POST request.
        $.ajax({
            url: "login.php",
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data !== ''){
                    $('#login-error').html(data);
                } else {
                    window.location = 'index.php';
                }
            }
        })
    });
});