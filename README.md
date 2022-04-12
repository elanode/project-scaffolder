# The Project Scaffolder
## Stack Info

- API - Laravel
- Admin/Client - Nuxt 2
- Oauth2 Authentication Flow

## Installation

- `make init-perms`
- `sudo make install`
- `make perm`
- `sudo make up`
- `sudo make php`
- `php artisan passport:client --public` (IF NOT SEEDED, check [`DatabaseSeeder.php`](./api/database/seeders/DatabaseSeeder.php))
  - [prompts] which user ... `1` (this is the superadmin id based on the users database)
  - [prompts] should name client ... `Nuxt Client App` (the name of the new consumer client)
  - [prompts] redirect request after auth ... `http://localhost:3000/oauth/login` (the redirect uri of consumer client used for logging in, setting cookies, etc)


---
---
## The API Directory Explained

### Introduction

First things first, this is the core codebase of the API only backend application. Uses Laravel as the framework. This API system adopt somekind of DDD approach and may evolve overtime when gaining more insights, drawbacks, etc.. The structure of the codebase will be explained below.

### Structure

Other than the `app/` directory, there's not so much customization from the Laravel itself.
#### `app/` Directory

This is where all the heart of the application layer lives. We structure the code to be more _domain driven_ (_modular?_) in a simpler approach, where we hope new developers may jump in and follow/read the code more easily. We will explain only the changes we made from the original Laravel's structure.

#### `Domains/` Directory

We split specific _Domains_ or _Contexts_ into self defining directory. We define the _domains_ based on business process that we want to build. For example, Authentication, Blogging, Shipping, Payment, etc. 

#### `Domains/[domain_name]/Actions/` >>> [jump link for example🚀](./api/app/Domains/Authentication/Actions/)

Here we put all the _Actions_ based on the use case of the business. The class must only contains one public method `public function run`. For example, `AttemptLoginUserAction`. This means, the class is responsible for attempting to login the user when the `run` function called.  


#### `Domains/[domain_name]/Dtos/` >>> [jump link for example🚀](./api/app/Domains/Authentication/Dtos/)

Here we put the _POPO_ file that represents the `Models` of this domain specific entities. The _DTO_ is responsible for creating simple object of the `Model`. Should only contains a `__construct`.

#### `Domains/[domain_name]/Enums/` >>> [jump link for example🚀](./api/app/Domains/Authentication/Enums/)

Here we put all the _Enum_ needed in this domain.

#### `Domains/[domain_name]/Exceptions/` >>> [jump link for example🚀](./api/app/Domains/Authentication/Exceptions/)

Here we put all the _Exceptions_ needed for this domain. All **Exception** must inherit(extends) [BaseCustomException](./api/app/Infrastructure/Exceptions/BaseCustomException.php) class.

#### `Domains/[domain_name]/Factories/` >>> [jump link for example🚀](./api/app/Domains/Authentication/Factories/)

Here we put all the _Factories_ for creating the _DTO_. This factory classes must contains `fromArray` and `fromRequest` methods. See one of the example in the Authentication Domain.

#### `Domains/[domain_name]/*` 

All laravel default directories (e.g. events, listeners, models, etc.) related to its domain needs are in here.
