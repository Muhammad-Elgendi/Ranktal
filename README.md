run containers 
sudo docker-compose up workspace php-worker nginx postgres pgadmin

access php artisan or bash on workspace containers
sudo docker-compose exec workspace bash

list containers
docker ps

Network details of container
docker inspect <container ID>

At the bottom,under "NetworkSettings", you can find "IPAddress"

Or Just do:

docker inspect <container id> | grep "IPAddress"

Or Check your container IP Address:
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' <container id>

