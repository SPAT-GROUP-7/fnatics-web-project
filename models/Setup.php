<?php
require_once ("models/Database.php");

/**
 * Class Setup
 *
 * This class should be ran on the first use of the system, it creates all necessary Database tables, foreign keys and indexes
 * as well as a means of accessing the system by setting up an administrator team and administrator account
 */
class Setup
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    protected $_dbHandle, $_dbInstance;

    /** Establish a connection to the database
     *
     * Setup constructor.
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    /**
     * This function will create all database tables and create an admin account
     */
    public function initialiseTables() {
        $this->createTeamsTable();
        $this->createUsersTable();
        $this->createRotaTable();
        $this->createLogsTable();
        $this->createUnavailableTable();

        $this->createAdminAccess();

        echo "<h1><a href='index.php'>Go to app</a></h1>";
    }

    /**
     * This function creates the Teams table
     */
    public function createTeamsTable()
    {
        $sqlQuery = "create table Teams
                        (
                            teamID      int auto_increment
                                primary key,
                            teamName    varchar(64) not null,
                            dateCreated datetime    not null,
                            lastUpdate  datetime    not null,
                            isBusy      int         not null
                        )
                            charset = utf8mb4; 
                            ";


        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $this->_dbInstance->destruct();

        echo "<h1>[INFO]: CREATED Teams TABLE</h1>";
    }

    /**
     * This function creates the Users table
     */
    public function createUsersTable() {
        $sqlQuery = "create table Users
                        (
                            userID      int auto_increment
                                primary key,
                            teamID      int                                    not null,
                            username    varchar(128)                           not null,
                            password    varchar(60)                            not null,
                            firstName   varchar(64)                            not null,
                            lastName    varchar(64)                            not null,
                            dateCreated datetime                               not null,
                            lastUpdate  datetime                               not null,
                            isAdmin     int                                    not null,
                            startDate   datetime default '2019-05-15 00:00:00' not null,
                            constraint username_UNIQUE
                                unique (username)
                        )
                            charset = utf8mb4; ";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $this->_dbInstance->destruct();

        echo "<h1>[INFO]: CREATED Users TABLE</h1>";

    }

    /**
     * This function creates the Rota table
     */
    public function createRotaTable() {
        $sqlQuery = "create table Rota
                        (
                            rotaID   int auto_increment
                                primary key,
                            dateFrom datetime not null,
                            dateTo   datetime not null,
                            devA     int      not null,
                            devB     int      not null,
                            constraint fkDavB
                                foreign key (devB) references Users (userID),
                            constraint fkDevA
                                foreign key (devA) references Users (userID)
                        );
                        
                        create index fkDavB_idx
                            on Rota (devB);
                        
                        create index fkDevA_idx
                            on Rota (devA);
                        ";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $this->_dbInstance->destruct();

        echo "<h1>[INFO]: CREATED Rota TABLE</h1>";
    }

    /**
     * This function creates the Logs table
     */
    public function createLogsTable() {
        $sqlQuery = "create table if not exists Logs
                     (
                        logID               int auto_increment
                            primary key,
                        logEditorID         int          not null,
                        logActionType       varchar(45)  not null,
                        logAffectedUser     varchar(128) null,
                        logAffectedTeam     varchar(64)  null,
                        logDate             datetime     not null,
                        logAffectedSchedule int          null,
                        constraint FKlogUserID
                            foreign key (logEditorID) references Users (userID)
                    );

                    create index FKlogUserID_idx
                    on Logs (logEditorID)";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $this->_dbInstance->destruct();

        echo "<h1>[INFO]: CREATED Logs TABLE</h1>";

    }

    /**
     * This function creates the Unavailable table
     */
    public function createUnavailableTable() {
        $sqlQuery = "create table Unavailable
                        (
                            unaID    int auto_increment
                                primary key,
                            userID   int      null,
                            teamID   int      null,
                            dateFrom datetime not null,
                            dateTo   datetime not null,
                            constraint unavailable_teamID
                                foreign key (teamID) references Teams (teamID),
                            constraint unavailable_userID
                                foreign key (userID) references Users (userID)
                        )
                            charset = utf8mb4;
                        
                        create index unavailable_teamID_idx
                            on Unavailable (teamID);
                        
                        create index unavailable_userID_idx
                            on Unavailable (userID);
                        ";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $this->_dbInstance->destruct();

        echo "<h1>[INFO]: CREATED Unavailable TABLE</h1>";
    }

    /**
     * This function creates an Administrator team as well as a default administrator account
     */
    public function createAdminAccess() {
        $sqlQuery = "INSERT INTO Teams (teamName, dateCreated, lastUpdate, isBusy)  
                     VALUES ('Administrator', now(), now(), 0);
                     
                     INSERT INTO Users (teamID, username, password, firstName, lastName, dateCreated, lastUpdate, isAdmin, startDate)
                     VALUES (1, 'admin@default.com', '$2y$11$1ShzvhjWqTGL8COZbudgj.3fJTI2StwVC4r5CWW6QURVdnWcy.vYS', 'Admin', 'Account', now(), now(), 1, now()); ";


        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $this->_dbInstance->destruct();

        echo "<h1>Created admin account + admin team</h1>";

    }
}