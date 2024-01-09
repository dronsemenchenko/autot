docker-compose up -d
docker exec -it autot-symfony sh ./docker/dev/fill-db.sh
docker exec -it autot-symfony php bin/phpunit
