//Stuff
function ajaxStuff(theUrl, form, formerr) {
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
   ajaxStuff("createUser.php", "#createUserForm", "#createUserError");
   ajaxStuff("createTeam.php", "#createTeamForm", "#createTeamError");
   ajaxStuff("editUser.php", "#edit-user-form", "#edit-user-error");
   ajaxStuff("editTeam.php", "#edit-team-form", "#edit-team-error")
});