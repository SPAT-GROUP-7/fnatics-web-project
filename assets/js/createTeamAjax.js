//Stuff

$(document).ready(function () {
    $('#createTeamForm').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "createTeam.php",
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data !== '') {
                    $('#createTeamError').html(data);
                } else {
                    location.reload();
                }
            }
        })
    });
});