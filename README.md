# dockerApp installation

- Stop your mysql and apache services : sudo service mysql stop && sudo service apache2 stop
- docker-compose build
- docker-compose up -d
- Connect to your php container : docker-compose exec php bash
- Install project dependencies : composer install
- Go to localhost:8080


# Containers connections

- MySQL : docker-compose exec mysql bash
- PHP : docker-compose exec php bash
- Apache : docker-compose exec apache bash
