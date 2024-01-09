docker-compose up -d<br>
docker exec -it autot-symfony sh ./docker/dev/fill-db.sh<br>
docker exec -it autot-symfony php bin/phpunit<br>
