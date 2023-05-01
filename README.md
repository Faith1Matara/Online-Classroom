## Online classroom 
### Abstract
The purpose of this online classroom project is to develop a comprehensive solution  that provides the students and instructors a flexible, accessible and secure way to access educational material and track progress.This platform will include features such as course content management, multimedia presentations, online assessment and a feature for tracking students' performance.This  platform will be designed to meet the needs of modern learners and educators and incorporates features to protect sensitive information.This online classroom platform  represents a significant step forward in the delivery of education and training and provides a solution for addressing challenges of traditional classroom settings.

### Installation
Step 1: Installing Apache

If you haven't already, you'll need to install the Apache web server on your computer or server. The exact steps will depend on your operating system, but generally involve downloading the Apache installer and running it.

Step 2: Installing PHP

You'll also need to install PHP, which is the programming language that the project is written in. Again, the steps will depend on your operating system, but you can usually install PHP through a package manager or by downloading the installer from the PHP website.

Step 3: Clone the project

 Click on the "Clone or download" button. Copy the HTTPS or SSH URL, depending on your preference. Open a terminal window and navigate to the directory where you want to store the project. Run the command: 
 ```
 git clone https://github.com/Faith1Matara/Online-Classroom.git 
 ```
to clone the project to your local machine.


Step 4: Configuring the project

The project have configuration files that located at `/opt/lampp/htdocs/ClassRoom/Include/config.php` that need to be modified to match your local environment. These file contain settings for the database connection.



### Running the project
Start Apache server - Start the Apache server using the appropriate command for your operating system. For example, on Ubuntu, you can start the Apache server using the command:
```
sudo service apache2 start
```

Start MySQL server: Start the MySQL server using the appropriate command for your operating system. For example, on Ubuntu, you can start the MySQL server using the command:
```
sudo service mysql start
```

Start PHP server: Start the PHP server using the command:
```
 php -S localhost:8000
 ```
  This will start a PHP development server on port 8000.

Open web browser: Open a web browser and navigate to http://localhost:8000 to view the project homepage or login screen.
### Tech Stack
Here are some of the technologies,libraries, frameworks and plugins used in the system.

### Technology
HTML5 - Page structure
CSS3 - Styling
PHP - Backend stuff
JavaScript - Frontend stuff
MySQL - Database

### Libraries
`PHPMailer` - A library for sending emails from PHP code, with support for SMTP.
Font Awesome or Google Fonts - These are libraries that provide access to pre-built icon sets or fonts that can help with styling and design.

### Framework
`Bootstrap` - It's a popular front-end frameworks that provide pre-built CSS and JavaScript components to help with responsive web design.

### Plugin
`mysqli`: It's a PHP extensions that provide access to MySQL databases and can help with performing common database tasks such as querying and data manipulation.

