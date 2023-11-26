# Student Report Generator

to run the generator command, use this docker command:
```
 docker-compose run app bin/console student:generate-report
```
to run automated tests, run this command:
```
 docker-compose run app php -d memory_limit=-1 vendor/bin/phpunit tests
```
to run phpstan checks, run this command:
```
 docker-compose run app php -d memory_limit=-1 vendor/bin/phpstan analyse 
```
to run phpcs checks, run this command:
```
 docker-compose run app php -d memory_limit=-1 vendor/bin/phpcs src tests -s 
```