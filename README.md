# Our Scaffolder

## Stack Info

- Laravel 9
- NuxtJs 2 (/admin, /client)
- Full Oauth2 Authentication by Passport

## Installation

- `make install`
- `make php`
- `php artisan migrate:fresh --seed`
- `php artisan passport:install`
- `php artisan passport:install --public`
  - [prompts] which user ... `1` (this is the superadmin id based on the users database)
  - [prompts] should name client ... `Nuxt Client App` (the name of the new consumer client)
  - [prompts] redirect request after auth ... `http://localhost:3000/oauth/login` (the redirect uri of consumer client used for logging in, setting cookies, etc)