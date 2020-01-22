//Creates an ajax post request from arguments that can return an error to the modal
//without reloading the page.
function ajaxPost(theUrl, form, formerr) {
    $(form).on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: theUrl,
            method: "POST",
            data: $(this).serialize(),
            success: function (data) {
                if (data !== '') {
                    $(formerr).html(data);
                } else {
                    location.reload();
                }
            }
        })
    });
}

$(document).ready(function () {
    ajaxPost("createUser.php", "#createUserForm", "#createUserError");
    ajaxPost("createTeam.php", "#createTeamForm", "#createTeamError");
    ajaxPost("editUser.php", "#edit-user-form", "#edit-user-error");
    ajaxPost("editTeam.php", "#edit-team-form", "#edit-team-error");
    ajaxPost("editCurrentSchedule.php", "#edit-schedule-form", "#edit-schedule-error");
});