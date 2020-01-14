//Stuff

$(document).ready(function () {
    $('#createUserForm').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "createUser.php",
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data !== '') {
                    $('#createUserError').html(data);
                } else {
                    location.reload();
                }
            }
        })
    });
});