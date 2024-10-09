# Note-Taking Application

A simple note-taking application built using HTML, PHP, and MySQL, allowing users to create, read, update, and delete notes. This application is designed to provide a straightforward way to manage personal notes.

## Features

- User authentication (registration and login)
- Create, read, update, and delete notes
- User-friendly interface for managing notes
- Secure handling of user data

## Requirements

- PHP >= 7.0
- MySQL database
- A web server (e.g., Apache or Nginx)
- Basic knowledge of HTML and PHP

## Installation

Follow these steps to set up the project locally:

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/iamlegendarium/note-app.git
   cd note-app

   ```

2. **Set Up the Database:**

   -Create a new MySQL database.
   -Import the SQL file provided in the database directory to set up the necessary tables.

3. **Configure Database Connection:**

   -Open the db_config.php file and update the database connection settings

   ```bash
   $servername = 'localhost';
   $username = 'your_username';
   $password = 'your_password';
   $dbname = 'your_database_name';
   ```

4. **Open XAMPP, start Apache & MySQL. Run the Application:**

   -Place the project files in the web server's root directory (e.g., htdocs for XAMPP).
   -Access the application via your web browser:

**Usage**
-Register a New Account:
-Navigate to the registration page and fill out the form to create a new account.
-Log In:

    -After registration, log in with your credentials.

**Manage Notes:**
Once logged in, you can create new notes, view existing notes, update them, or delete them.

**License:** This project is licensed under the MIT License.

**Author:** AREGBESOLA JOHN BELOVED +2348118870050
