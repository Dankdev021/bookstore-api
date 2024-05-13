# bookstore-api
Activity to create a CRUD API that simulates a book store

Postman documentation link (routes used during development) : https://red-eclipse-538052.postman.co/documentation/20151149-b380a22c-8f08-482e-adfc-ac4d56a34241/publish?workspaceId=d8644c36-e339-4702-8394-fb715a7f3e29


Database used: SQLite (Due to the low complexity and aiming for better performance through the low amount of data, I chose to use this lighter database)


1 - To use this project just download the project from this repository

1 - Just clone this repository using git clone <url_project>

2 - Execute the command : composer install

3 - Create the database.sqlite file inside the laravel database folder

4 - Create .env file to add database settings Below is an example of what these settings will look like

DB_CONNECTION=sqlite
DB_DATABASE=/home/daniel/bookstore-api/bookstore-api/database/database.sqlite

See that I used the absolute file path to make things easier

5 - Execute the command : php artisan key:generate

6 - Execute the command : php artisan migrate (This will create the necessary tables)

7 - up server : php artisan serve


NOTE : The route documentation for this project can be very useful when testing as the routes are named and can help with this

NOTE : If you are using postman to test, remember to always define the baraer token in the routes
(token obtained when logging in)

