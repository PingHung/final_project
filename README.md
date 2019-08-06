# IS601 Final Project - Ping Hung Ho 
Heroku: https://ping-final-project.herokuapp.com/

A voting feature is added into this project. 
The tutorial video which used is  
https://www.youtube.com/watch?v=y5qZJ7sYN88
 
Epic: User can vote up or down on the posted answers.

Storeis:
1. User can vote up on posted answers.
2. User can vote down on posted answers.
3. User can click on his/her vote again to cancel the vote.
4. User can switch his/her vote by clicking the opposite option.

To run the project:

    git clone 
    run: composer install
    cp .env.example to .env
    run: php artisan key:generate
    setup database with sqlite
    Run: php artisan migrate
    Run: seeds php artisan migrate:refresh --seed
    unit tests: vendor/bin/phpunit

