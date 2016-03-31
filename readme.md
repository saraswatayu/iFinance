## iFinance

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)

## Usage

1. Create a new database with the name `iFinance`.
2. Navigate to the project directory in terminal.
3. Use the command `php artisan migrate` to set up the tables.
4. Use the command `php artisan serve` to start the web server.
5. Point your web browser to `http://localhost:8000/` to get started!

## Registering a New User

1. Navigate to `app/Http/` in the project directory.
2. Open the `routes.php` file in the text editor of your choice.
3. Replace `auth.login` with `auth.register`.
4. Sign up with a new account and undo the changes made in Step 3.

## Notes

For this application to turn corretly you need to have an instance of mysql on your localhost.
You can download XAMPP and start mysql service in the settings. Make sure to create table 'iFinance'
