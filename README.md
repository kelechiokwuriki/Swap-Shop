<p align="center">
   Swap Shop Platform
</p>

## About the Swap Shop Platform
Members of a community are able to trade items within themselves. They can sign up on the platform, post items they have or want for exchange. The platform also offers the abilty to create events. <br/>
Every week, the members of the platform get an email notification of all listings and events, this is done by an admin who manages the platform.


## Manual Install
Download or clone the repository.
You will need Composer. Installing this globally is recommended.
* Run "composer install" to fetch and install dependencies
* Copy the .env.example file to .env . You can customise settings however you wish, but you must specify your database information. You can use whichever database driver that your PHP installation can support - the default is MySQL.
* Update the mail details in the env with your created outgoing email server
* If you wish to run the program in development mode, change the APP_ENV value to local.
* Run "php artisan key:generate" to populate your .env file with a new key.
* Run "php artisan config:cache" to optionally cache your configuration. This is for performance.
* Run "php artisan migrate" (or php artisan migrate:fresh if you've run it previously) to provide a fresh database structure to your specified database.
* Run this to create a user with admin capabilities
* Update the mail details in the env with your created outgoing email server
* Run "npm run dev" to compile the front end assets.
* Run "php artisan serve" to kick up the server




## Automated Install
An automated installer is available for Linux and macOS. Simply run bash install.sh after downloading or cloning the repository. It is currently untested with Windows Subsystem for Linux or other Bash
implementations under Windows, so proceed with caution. For help setting up your .env file, please see the below section.





