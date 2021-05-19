# material_forum
Another forum, but inspired by Material Design and with custom MVC architecture

# What you need
This forum is made in **PHP 7**, use a **MySQL 5** database (but could work with a **SQLite** database too) and has some dependencies managed by **Composer**.
So, a local dev environment like Laragon or WampServer provide is sufficient.

# How to install
0. Put the files in your webroot folder !
1. Install dependencies with [composer](https://getcomposer.org/) :

    composer install
    
2. Rename the __.env-dev__ file to __.env__ and modify the settings as needed
3. Execute the SQL written in **script-db.sql** in your MySQL server (don't forget to create the database first...)