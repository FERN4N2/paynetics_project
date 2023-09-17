# Projects and Tasks RestAPI example

Requirements:
- RestAPI endpoints to CRUD the Tasks and Projects
- Soft deletes on the data
- Create a FrontEnd page that presents the data in the tables (with pagination)

### Notes:
- The fields of the model Task were not specified in the task subject so I chose to give it a task `name` and a `completed` field to evaluate the `status` of the parent project.
- Since `status` is depending on the Project's children tasks, I opted not to have it as a table field, but as a computed property. The task orientation did not forbid otherwise.
- Soft deletes have been used, by default laravel uses a `deleted_at` timestamp for this.
- The "simple visual template" only "presents" the data from the tables, nothing more, as explained in the task orientation.

## Tech Stack:
- PHP 8
- Framework: Laravel 10
- Database: PostgresSQL
- Eloquent ORM used for Database handling

## Deployment
- Download repository from GITLAB: (link)
- Install Composer
- Install composer dependecies
- Install PostgresSQL support
- Set up PostgresSQL access in .env file
- Run laravel's artisan migration script to create the tables `php artisan migrate`
- Run laravel's artisan seeder to populate the tables `php artisan db:seed`
- Run the dev web server `php artisan serve`
- Access the server's URL (defacto 127.0.0.1:8000)
- To access the RestAPI endpoints, I suggest using a tool like POSTMAN, the URLS are:
  - /projects *(for the projects)*
  - /projects/{id_project}/tasks  *(for the tasks of each project)*
- Request verbs are the usual (GET, PUT, DELETE..)

*Feel free to email me for further questions or updates :)*

*All the best!*

*Fernando.*

***nota: there may be some vue files in the project folder, i started to import it, but noticed it wasnt really necessary to make a JS Front End***
