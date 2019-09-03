Ozzie
======
**Ozzie** Tighten's Open Source Projects Monitor

## Local Development
1. Clone the repo.
2. run `composer install`
3. Copy the .env example file: `cp .env.example .env`
4. Create an Oauth Application on [GitHub](https://github.com/settings/developers);
  - If you use `php artisan serve` to serve your application locally, you can use the following settings:
    - Application Name: Local Ozzie
    - Homepage URL: http://127.0.0.1:8000
    - Application Description: Local Version of Ozzie
    - Authorization Callback URL: http://127.0.0.1:8000/callback
5. Copy the client ID and secret from the previous step into your .env file.`
6. run `php artisan serve` and visit http://127.0.0.1:8000
