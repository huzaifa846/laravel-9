# Project Name

## Laravel Email API

### Overview

This project is a Laravel-based API for sending multiple emails asynchronously to specific users. The API includes endpoints for sending emails and listing sent emails. It leverages Elasticsearch for storing email information and Redis for caching.

### Getting Started

After cloning the repository, follow the steps below:

1. Run the following command to set up the database:

    ```bash
    php artisan migrate:fresh --seed
    ```

2. Login API:

   - **URL:** [http://127.0.0.1:8000/api/login](http://127.0.0.1:8000/api/login)
   - **Email:** testuser@mail.com
   - **Password:** 1234

   ![Login Api](https://github.com/huzaifa846/laravel-9/assets/69592870/9aa62547-4a06-4d9b-aa93-0cdb20490130)

3. Send Emails API:

   - **URL:** [http://127.0.0.1:8000/api/w9eQvHv3ei28mbSs36ZuxiELpSdilRRC8bxFmIx5EvXXpaoRjIKdaLoaml5u/send](http://127.0.0.1:8000/api/w9eQvHv3ei28mbSs36ZuxiELpSdilRRC8bxFmIx5EvXXpaoRjIKdaLoaml5u/send)

![Send Email Api](https://github.com/huzaifa846/laravel-9/assets/69592870/530d3e7f-19d0-4bc1-978c-1ffaaec917eb)


4. Emails List API:

   - **URL:** [http://127.0.0.1:8000/api/list](http://127.0.0.1:8000/api/list)

   ![Emails List](https://github.com/huzaifa846/laravel-9/assets/69592870/7d90eda1-71e8-4329-8361-7241d85969f6)

### Project Requirements

This project fulfills the following requirements:

- **Endpoint for Sending Emails:**
  - Supports the sending route: `POST api/{user}/send`
  - Accepts an array of emails, each with a subject, body, and recipient email address.

- **Email Handling:**
  - Builds a Mail object using standard Laravel functions and the default email provider.
  - Uses a job to dispatch emails asynchronously, leveraging Redis/Horizon setup.

- **Data Storage:**
  - Stores information about sent emails in Elasticsearch using a class implementing the ElasticsearchHelperInterface.

- **Caching:**
  - Caches information about sent emails in Redis using a class implementing the RedisHelperInterface.

- **Unit Testing:**
  - Includes unit tests to ensure the correct dispatch of jobs and handles validation errors.

### Bonus Features

This project includes bonus features:

- **List Sent Emails:**
  - Endpoint `api/list` lists all sent emails with details such as email, subject, and body.

- **Unit Testing for List Endpoint:**
  - Unit tests for the `api/list` route to ensure expected subject/body.














