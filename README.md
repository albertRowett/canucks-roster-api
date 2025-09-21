# Vancouver Canucks Roster API - RESTful API

Laravel-built API tracking the roster of the Vancouver Canucks ice hockey team.

[API Documentation](https://canucks-roster-api.infinityfree.me/)

## Introduction

The aim of this project was to consolidate my understanding of REST APIs, Laravel and testing by building an API to track the roster of the Vancouver Canucks, the ice hockey team I follow. I chose this project because I thought the changes affecting a team roster would map well onto the CRUD operations. Additionally, I wanted to gain experience writing API documentation, as I had not done this before.

I used PHP and the Laravel framework to streamline the creation and organisation of classes and the database, as well as to handle database interactions. I utilised MySQL for database management and Docker to create a consistent development environment. Testing was implemented using PHPUnit, built into Laravel, providing a reliable means to achieve well-tested code. Finally, I created a Blade template to host the API’s documentation, which I styled with CSS and JavaScript.

One of the most challenging parts of this project was defining the model relationships and designing a database structure to support them. Setting up the associations between the player, draft team, previous team and team models to accurately reflect their real-world relationships was particularly complex, but this forced me to gain a deeper understanding of Laravel’s Eloquent ORM and relational database design. Additionally, I learned several useful, new techniques, including using try and catch blocks for exception handling, implementing transactions to avoid permanent database changes in the event of errors and utilising Laravel’s built-in soft deletion functionality.

## Features

-   **CRUD operations.** Add, view, edit and delete players from the roster, with separate routes to view positions and nationalities.
-   **Filtering.** Filter players by roster status, position and/or nationality for more targeted queries.
-   **Soft deletion.** Temporarily remove players from the roster (e.g. due to injury), with the option to reinstate them later.
-   **Custom responses.** Standardised success and error messages improve the clarity of API interactions.
-   **Database transactions.** Ensure data integrity by rolling back changes if errors occur during multi-step operations, preventing partial updates.
-   **Thorough testing.** Comprehensive tests cover all API endpoints and service layer methods, ensuring the reliability of core functionalities.
-   **API Documentation.** Clear, detailed documentation outlines the available endpoints, request formats and expected responses.

## Installation

1. Clone the repository:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`git clone https://github.com/albertRowett/canucks-roster-api.git`

2. Navigate to the project directory:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`cd canucks-roster-api`

3. Install dependencies:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`composer install`

4. Configure the database connection:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copy the example environment file: `cp .env.example .env`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Open the new **.env** file and update the database connection details.

5. Set up Docker (if applicable):

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If using Docker for your development environment, start the containers: `docker-compose up --detach`

6. Generate an application key:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`php artisan key:generate`

7. Run the database migrations:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`php artisan migrate`

8. Serve the application:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`php artisan serve`

9. Access the API:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Access the API at http://localhost:8000/api (if using Docker, check your setup for an alternative port if **8000** is already in use).

## Testing

This project includes both HTTP tests to validate the API endpoints and integration tests covering the internal service layer's methods, ensuring their correct functionality with the models and database.

Run all tests with the command: `php artisan test`

## Contributing

While no major updates are planned for this project, I welcome bug reports and suggestions for improvements. Drop me an email at <albertRowett@gmail.com>

## Acknowledgements

Technologies used to build the API:

-   [Laravel](https://laravel.com/)
-   [Docker](https://www.docker.com/)

Advice on database structure and deployment:

-   My former trainer [@ashleycoles](https://github.com/ashleycoles)

Inspiration for API documentation structure:

-   [@iros](https://github.com/iros)'s [REST API documentation template](https://gist.github.com/iros/3426278)

Favicon image source:

-   [freesvg.org](https://freesvg.org/)

<br>

_All last accessed 9 October 2024_
