# fanatics-web-project

## Setup Instructions
1. Clone the git repository from the latest commit to MASTER (this is the current stable version)
2. Create a database on your chosen platform
3. create a file called Secret.php in the models directory (as shown below)
![An image showing the directory structure for the project](https://i.gyazo.com/a58693ba4c2fc442cd5a12ccf59ba2e4.png)


4. copy and paste the following code, replacing the empty strings with your database information

```
  class Secrets
{
    static $USERNAME = "";
    static $PASSWORD = "";
    static $HOST = "";
    static $DB_NAME = "";


}
  ```
(Note: you may want to add this file to your .gitignore for security reasons)
  
5. start your development server
6. on your browser, navigate to setup.php

![An image showing a browser with the address localhost:8080/setup.php](https://i.gyazo.com/a49cc5a4eeeae82015f032982e330d38.png)

7. after it has finished initialising the database click the link to go the index page
8. click the login modal and log in to the system with the default account created by setup.php.
```
USERNAME: admin@default.com 
PASSWORD: testpass
```
(DELETE THIS ACCOUNT AFTER YOU HAVE GAINED ACCESS TO THE SYSTEM FOR SECURITY REASONS)

9. all setup steps have been completed, setup the Teams and User accounts according to your needs

(if you encounter issues or would like to contribute, please submit a github issue or submit a pull request)
