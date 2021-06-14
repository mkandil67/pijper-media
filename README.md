# Pijper-Media
This repository is to manage the workflow of the social wall application RUG's Software Engineering team developed for the Pijper Media company.

*```||``` stands for Logical OR, it is not something you should write in your terminal.

# Dependencies Tutorial
## What are the dependencies?
You can find the dependencies of the application we developed in the order of priority here (Note that some are requirements to install others)
1. PHP
2. Composer
3. Laravel
4. Node.JS
5. XAMPP
6. Different Libraries used during the development procedure

## Installing the dependencies
### Preresiquites
Most probably, your machine already has an instance of MySQL and Apache2 already installed, however these are also preresiquites of our program so please follow these links if you do not have them. 
1. To check if you have them please type in your shell: ```apache2 -v || mysql -v;```
2. If you get a message with a version, then you're all set to follow this tutorial;
3. Else, please consult these links for the installation of MySQL and Apache2:
<ul> <li> https://dev.mysql.com/doc/mysql-installation-excerpt/8.0/en/windows-install-archive.html (For MySQL) </li>
 <li> https://www.sitepoint.com/how-to-install-apache-on-windows/ (Windows) || https://ubuntu.com/tutorials/install-and-configure-apache#1-overview (Ubuntu) || https://tecadmin.net/install-apache-macos-homebrew/ (Mac) </li> </ul>
 ### PHP
 To install the last version of php, please consult this link:
 https://kinsta.com/blog/install-php/#php-prerequisites
 In here you can find a step by step guide to download PHP on any operating system.
 ### Composer
 Composer is the main packaging system for php libraries and frameworks, it is used to install Laravel as well as the other libraries used in our project (ex: Facebook Graph API SDK). To install composer on you Operating System, please consult this website:
 https://getcomposer.org/download/
 The easiest way to download composer locally is to run this script in your project's root folder, in our case it's the /pijper-media/ directory.
 
 ### Laravel
 Since we already have the dependencies for Laravel installed, it suffices to run this command in your terminal:
 ```composer global require laravel/installer```
 After that, you need to include the installation in your path. To do so, please consult the **Installing Laravel** Section of this link:
 https://laravel.com/docs/7.x
 
 ### Node.JS
 The node modules are already downloaded in our project that you are going to pull from the repository, however, please run ```npm install``` on your terminal to get the latest updates. Do so in the social-wall-app directory. This will ensure all bootstrap and javascript files are read correctly.
 *To check whether you have npm or not (pretty unlikely to not have it), please run ```npm -v``` in your terminal*
 
 ### XAMPP
 Please use the following link to install XAMPP:
 https://www.apachefriends.org/index.html
XAMPP is an Apache2 and MySQL client that runs databases on your localhost/IP Address.

### Libraries
The last step is to download all libraries used in our project, this could be a hard task but fortunately, composer simplifies it.
Inside these 5 folders:
1. /social-wall-app/
2. /util/
3. /facebookData/
4. /instagramData/
6. /twitterData/

Run the following commands in order:
```composer install```
```composer update```

Once these steps are done, you can proceed to running the application.

## Running the Application

To run our application, please perform those tasks in the following order:
1. Open XAMPP (wherever you downloaded it) and start the MySQL server aswell as the Apache2 server. *In case one of them is not running, please stop the default apache2/mysql server(s) on your machine. For example, this can be done in linux by running the command ```sudo service apache2 stop```*.
2. Go to the \social-wall-app\ directory and run the following command in your terminal ```php artisan migrate```, this command will run all of the outstanding migrations.
3. Consult the link http://localhost/phpmyadmin in your browser and go to the last database.
4. Again go to the \social-wall-app\ directory and run the following command in your terminal ```php artisan schedule:work```, this command will start filling the database with the most recent posts from instagram, facebook and twitter as well as checking if they are trending. This will happen every 10 minutes.
5. Open a new tab in the same directory in your terminal and run the command ```php artisan serve```, this will open the application on port number 8000 in your localhost.
6. Visit the webpage by entering ```127.0.0.1:8000/``` into your webbrowser and test the application!

If reviewer wants to run the program on a development server and the below listed tutorial was not enough, please contact us so we can schedule a session to help you with detailed information about how to run the program correctly. In the case you contact us to install the dependancies, please tell us the OS you are using beforehand so we can be ready.

Thank you for your time, we're waiting to hear from you!