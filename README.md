# Temper PHP Assessment

This project is proving a solution to Temper to get an idea of how users are performing in the Onboarding Flow

## Server Requirements

- PHP >= 7.3
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Composer

## Setup Instructions

1. Download or clone the repository.
   `git clone git@github.com:rdanusha/TMPR-PHP-Assessment.git`
2. Switch to the repo folder. Run command `cd TMPR-PHP-Assessment`
3. Install all the dependencies using composer.  Run command `composer update`
4. Rename the .env.example file as .env file. Run command `cp .env.example .env` for Windows run command `copy .env.example .env`
5. Generate a new application key.  Run command`php artisan key:generate`
6. Install all the JS dependencies and build scripts. Run command `npm install && npm run dev`
7. Start the local development server. Run command `php artisan serve`

You can now access the server at http://127.0.0.1:8000

## Run Test Cases
1. Switch to the repo folder `cd TMPR-PHP-Assessment`
2. Run command `php artisan test`

## API Documentation
For api documentation visit :
`{domain_name}/api/documentation`

Ex: http://127.0.0.1:8000/api/documentation

## Screenshot

![Alt text](result-screenshot.png)
