# Dorset Demons Fundraiser App

## Summary

A basic web app to track the progress of Dorset Demon's June 2025 charity event. The event includes the team rolling/walking/running/pushing 1024 miles between them in a month. THe web app allows team members to log in and enter the miles they have done for the day and shows a total tally for any visitors to the site. The site also includes social links for the club and a donation link.

The project has been written in and tested on PHP 8.2 with a MariaDB database and Apache web server.

## Deployment

Configuring the deployment will vary based on the machine. This project has been tested and confirmed working on Debian 12 and Rocky Linux 8.10.

### Required PHP Modules

- php-cli
- php-mbstring
- php-mysqlnd
- php-opcache
- php-pdo
- php-xml

### Database configuration

Once you have installed and started your MariaDB server, create a database and user with the following SQL commands.

```
CREATE database database_name_here;
CREATE USER user_name_here@localhost IDENTIFIED BY 'password_here';
GRANT ALL on database_name_here.* TO user_name_here@localhost;
```

### Email

The project has been written to use Amazon SES to send emails. You will need to configure Amazon SES yourself and provide an AWS key and AWS secret to the application to allow it to send emails.

### The webserver

Start by downloading and unzipping the webserver in your preferred location, typically this will be `/var/www/`. You will then need to tell your apache webserver where this is. Ensure that apache has permissions to access the web server directory and that the webserver document root is set to the `public` folder in this project.

> **Warning** Setting the apache document root to the root of this project will cause the project not to work as expected and may expose your database and AWS credentials

Once the webserver has been configured, rename the `config.php.example` file to `config.php` and fill out the missing credetials. You can then start your webserver and visit the site.

## User Management

Only users which have been added to the app will be able to login. There are no passwords but users will be sent a magic login link on attempting to login. To add a new user, run the `scripts/createUser.php' script and follow the wizard to add the user.

## Docker (in development)

Currently the web server is available to run in a docker container. Before building the container, you will first need to enter your database credentials and base url in the config.php file. You will also need to provide a `server.crt` and `server.key` in the `docker/cert` directory. The container can be built using

`docker build -t dd-fundraiser .`

and then run with

`docker run --rm -p 443:443 --name dd-fundraiser dd-fundraiser`
