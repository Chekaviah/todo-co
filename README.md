# ToDo & Co

[![Build Status](https://travis-ci.org/Chekaviah/todo-co.svg?branch=master)](https://travis-ci.org/Chekaviah/todo-co) 
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/2b15f52433d14888a45dd19aadc58a80)](https://www.codacy.com/app/Chekaviah/todo-co?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Chekaviah/todo-co&amp;utm_campaign=Badge_Grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/130eed3865598f598097/maintainability)](https://codeclimate.com/github/Chekaviah/todo-co/maintainability)

Todo & Co is a symfony 3 project for the Openclassrooms "Application developer" path. 

## Requirements 
- PHP >= 5.6
- MySQL >= 5.7.11
- [Composer](https://getcomposer.org/)
- [Symfony application requirements](https://symfony.com/doc/3.1/reference/requirements.html)

## Installation 
1. Clone the master branch
1. Install dependencies `composer install`
1. Edit the parameters.yml file to setop configuration for mailer and database
1. Generate the SSH keys with JWT passphrase in .env and add JWT keys path 
1. Create database `bin/console doctrine:schema:create`
1. Load data fixtures `bin/console doctrine:fixtures:load -n`
1. Run PHP's built-in Web Server `bin/console server:run`
1. Navigate to [localhost:8000](http://localhost:8000)

## Tests
1. Create tests database `bin/console doctrine:schema:create --env=test`
1. Load tests data fixtures `bin/console doctrine:fixtures:load --env=test -n`
1. Run units and functionals tests `bin/phpunit`

## Contributing

Please see [CONTRIBUTING.md](https://github.com/Chekaviah/todo-co/blob/master/CONTRIBUTING.md)
