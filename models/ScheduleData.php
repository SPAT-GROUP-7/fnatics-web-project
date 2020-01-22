<?php
require_once ("Database.php");
require_once("Schedule.php");
require_once ("UserData.php");


/**
 * Class ScheduleData
 * This class is used to aggregate a collection of Schedule Objects
 */
class ScheduleData
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    /**
     * @var Database|PDO|UserData : An instance of UserData is required to manipulate User Objects
     */
    protected $_dbHandle, $_dbInstance, $_userData;

    /** Establish a connection to the database and instantiate the UserData class
     *
     * ScheduleData constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
        $this->_userData = new UserData();
    }

    /** This function returns a Schedule Object by searching for one with a corresponding ID passed as a parameter
     *
     * @param $id : The ID of the rota Object to retrieve
     * @return array : Retrieves a Schedule object if found
     */
    public function getRota($id) {
        $query = "SELECT * FROM Rota WHERE rotaID = :rotaID";
        $statement = $this->_dbHandle->prepare($query);
        $statement->bindValue(":rotaID", $id, PDO::PARAM_INT);

        $statement->execute();
        $this->_dbInstance->destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Schedule($dbRow);
        }
        return $dataSet;
    }

    /** This function will retrieve all Schedule Objects in the system
     * @return array : A collection of Schedule Objects
     */
    public function getAllRotas() {
        $sqlQuery = "SELECT R.rotaID, R.dateFrom, R.dateTo, CONCAT(A.firstName, ' ', A.lastName) as devA, CONCAT(B.firstName, ' ', B.lastName)as devB
                     FROM Rota R
                        JOIN Users A on R.devA = A.userID
                        JOIN Users B ON R.devB = B.userID
                     ORDER BY R.dateFrom";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = Schedule::fromRow($dbRow);
        }

        $this->_dbInstance->destruct();
        return $data;
    }

    /**
     * @param $from : The start of a Schedule in the format Y-m-d
     * @param $to : The end of a Schedule in the format Y-m-d
     * @return array : A colllection of Schedule Objects
     */
    public function getRotas($from, $to) {
        $sqlQuery = "SELECT R.rotaID, R.dateFrom, R.dateTo, CONCAT(A.firstName, ' ', A.lastName) as devA, CONCAT(B.firstName, ' ', B.lastName)as devB
                     FROM Rota R
                        JOIN Users A on R.devA = A.userID
                        JOIN Users B ON R.devB = B.userID
                     WHERE R.dateFrom >= :dateFrom AND R.dateTo <= :dateTo 
                     ORDER BY R.dateFrom";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":dateFrom", $from, PDO::PARAM_STR);
        $statement->bindValue(":dateTo", $to, PDO::PARAM_STR);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = Schedule::fromRow($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }


    /** This function will retrieve all Schedules that a given User is on shift
     *
     * @param $id : The ID of the user
     * @return array : A collection of Schedule Objects where the user with a corresponding ID is on shift
     */
    public function getUserSchedules($id) {
        $sqlQuery = "SELECT R.rotaID, R.dateFrom, R.dateTo, CONCAT(A.firstName, ' ', A.lastName) as devA, CONCAT(B.firstName, ' ', B.lastName)as devB
                     FROM Rota R
                        JOIN Users A on R.devA = A.userID
                        JOIN Users B on R.devB = B.userID
                     WHERE R.devA = :userID OR R.devB = :userID
                     ORDER BY R.dateFrom";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":userID", $id, PDO::PARAM_INT);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = Schedule::fromRow($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    /** When publishing new Schedules this function checks if one exists for the given date range
     *  (to allow for it to be updated with the new information)
     *
     * @param $from : The start date of the Schedule in the format Y-m-d
     * @param $to : The end date of the Schedule in the format Y-m-d
     * @return bool : If a schedule is found matching these dates it will return true
     */
    public function scheduleAlreadyExists($from, $to) {
        $sqlQuery = "SELECT * FROM Rota R
                     WHERE R.dateFrom = :dateFrom AND R.dateTo = :dateTo";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":dateFrom", $from, PDO::PARAM_STR);
        $statement->bindValue(":dateTo", $to, PDO::PARAM_STR);

        $statement->execute();

        $schedulesFound = $statement->rowCount() > 0;

        $this->_dbInstance->destruct();

        return $schedulesFound;
    }

    /** This function will create a Schedule by first checking if there is an existing schedule for the date range
     *  If so, it will update the existing schedule as opposed to creating a new one
     *
     * @param $from : The start date of the Schedule in the format Y-m-d
     * @param $to : The end date of the Schedule in the format Y-m-d
     * @param $devA : The ID of the 1st developer
     * @param $devB : The ID of the 2nd developer
     */
    public function createRota($from, $to, $devA, $devB) {

        $scheduleExists = $this->scheduleAlreadyExists($from, $to);

        if ($scheduleExists) {
            $this->updateRota($from, $to, $devA, $devB);
        }
        else {
            $sqlQuery = "INSERT INTO Rota (dateFrom, dateTo, devA, devB)
                         VALUES (:dateFrom, :dateTo, :devA, :devB)";

            $statement = $this->_dbHandle->prepare($sqlQuery);
            $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $statement->bindValue(":dateFrom", $from);
            $statement->bindValue(":dateTo", $to);
            $statement->bindValue(":devA", $devA, PDO::PARAM_INT);
            $statement->bindValue(":devB", $devB, PDO::PARAM_INT);

            $statement->execute();

            $this->_dbInstance->destruct();
        }
    }

    /** This function will update an already existing Schedule with new information
     *
     * @param $scheduleID : the ID of the Schedule to be updated
     * @param $devA : the ID of the 1st developer
     * @param $devB : the ID of the 2nd developer
     */
    public function updateRota($scheduleID, $devA, $devB)
    {
        $sqlQuery = "UPDATE Rota R
                     SET R.devA = :devA,
                         R.devB = :devB
                     WHERE R.rotaID = :scheduleID";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":scheduleID", $scheduleID, PDO::PARAM_INT);
        $statement->bindValue(":devA", $devA, PDO::PARAM_INT);
        $statement->bindValue(":devB", $devB, PDO::PARAM_INT);

        $statement->execute();

        $this->_dbInstance->destruct();

    }


    /** This function will generate N rotas (depending on the distance between the start and end date)
     *  taking into account only users who are available for the date range, how long they've been at the company
     *  and wont select 2 developers from the same team
     *
     * @param $from : The date to being the generation
     * @param $to : The date to end the generation
     * @return array : A collection of temporary Schedules
     */
    public function generateRotas($from, $to) {

        /*
         * REFINED ALGORITHM:
         * For each schedule:
         *      Get a list of all non-admins who have been at the company for 4 months or more
         *      Get a list of all users who are unavailable for the current Schedule (absent / busy)
         *
         *      Let AvailableUsers = the set difference of (non-admins, unavailable users)
         *      Let devA = random selection from AvailableUsers
         *          Remove devA from consideration
         *      Let devB = random selection from AvailableUsers
         *          If devB is on the same team as devA
         *              Re-select devB
         *          Else
         *              select devB
         *      Create provisional Schedule(From, To, devA, devB)
         */

        // The length of a Schedule
        $shiftLength = 14;

        $rotas = [];

        $dateFrom = date_create($from);

        $dateTo = date_create($to);

        $nonAdminsBase = $this->_userData->getAllNonAdmins();

        // N = the number of Schedules to generate
        $n = ceil($dateFrom->diff($dateTo)->days / $shiftLength) ;

        for ($i = 0; $i < $n; $i++) {

            // the number of days to add to the start date
            // EG: 2nd schedule, 1 * 14 = 14, add 14 days to the start date
            $add = ($i * $shiftLength);

            $from = date("d-m-Y", strtotime($dateFrom->format("d-m-Y"). ' + ' . $add . ' days'));
            $to = date("d-m-Y", strtotime($from. ' + 14 days'));

            // Convert the from date into the format the database expects
            $dateDB = date('Y-m-d', strtotime($from));

            $nonAdmins = $nonAdminsBase;
            $unavailable = $this->_userData->getAllUnavailableUsers($dateDB);

            // Get the set difference of $nonAdmins and $unavailable to determine the list of available users
            $availableUsers = array_udiff($nonAdmins, $unavailable, function($obj_A, $obj_B) {
                return ($obj_A->getUserID() - $obj_B->getUserID());
            });

            $indexA = array_rand($availableUsers, 1);

            $devA =  $availableUsers[$indexA];

            unset($availableUsers[$indexA]);

            $indexB = array_rand($availableUsers, 1);
            $devB =  $availableUsers[$indexB];

            while ($devA->getTeamName() == $devB->getTeamName()) {
                $indexB = array_rand($availableUsers, 1);
                $devB =  $availableUsers[$indexB];
            }

            $rotas[] = Schedule::fromString($from, $to, $devA, $devB);
        }
        return $rotas;
    }
}
