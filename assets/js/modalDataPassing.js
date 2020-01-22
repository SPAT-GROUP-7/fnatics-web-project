// All stuff which passes data from tables to modals.
$(document).ready(function () {

    // Edit User
    $('.editUserBtn').on('click', function () {
        const $tr = $(this).closest('tr');

        const data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#eum-username').val(data[0]);
        $('#eum-firstName').val(data[1]);
        $('#eum-lastName').val(data[2]);
        $('#eum-team option').filter(function () {
            return ($(this).text() === data[3]);
        }).prop('selected', true);

        if (data[4] === "Yes"){
            $('#eum-isadmin').prop('checked',true);
        } else {
            $('#eum-isadmin').prop('checked',false);
        }

        const userID = $(this).data('id');
        $("#eum-userID").val(userID);
    });

    // Edit Team
    $('.editTeamBtn').on('click', function () {
        const $tr = $(this).closest('tr');

        const data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#etm-teamname').val(data[0]);

        if (data[1] === "Yes"){
            $('#etm-isbusy').prop('checked',true);
        } else {
            $('#etm-isbusy').prop('checked',false);
        }
        $('#etm-isBusyFrom-').val(data[1])
        $('#etm-isBusyto-').val(data[2])
        const teamID = $(this).data('id');
        $('#etm-teamID').val(teamID);
    });

    // Delete User
    $('.deleteUserBtn').on('click', function () {
        const $tr = $(this).closest('tr');

        const data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#duw-name').text(data[1] + " " + data[2]);

        const userID = $(this).data('id');
        $("a#duw-button").prop("href", "deleteUser.php?userID=" + userID);
    });

    // Delete Team
    $('.deleteTeamBtn').on('click', function () {
        const $tr = $(this).closest('tr');

        const data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#dtw-name').text(data[0]);

        const teamID = $(this).data('id');
        $("a#dtw-button").prop("href", "deleteTeam.php?teamID=" + teamID);
    });

    // edit Schedule
    $('.editScheduleBtn').on('click', function () {
        const $tr = $(this).closest('tr');

        const data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#dtw-').text(data[0]);

        const scheduleID = $(this).data('id');
        $("a#dtw-button").prop("href", "editSchedule.php?scheduleID=" + scheduleID);
    });

    // edit current schedule
    $('.editCurrentScheduleBtn').on('click', function() {
        const $tr = $(this).closest('tr');
        const data = $tr.children('td').map(function() {
            return $(this).text();
        }).get();

        $("#etm-userID").prop("value", data[0]);

        $("#eum-devA option").filter(function() {
            return ($(this).text()) === data[3]
        }).prop("selected", true);

        $("#eum-devB option").filter(function() {
            return ($(this).text() === data[4])
        }).prop("selected", true);
    });
});