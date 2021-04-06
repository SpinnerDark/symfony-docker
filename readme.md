# Symfony 5 con Docker
**Iniciar el docker (instalación)**

Desde la carpeta raíz del projecto ejecutar:
```
sudo docker-compose up --build
```
## Instalar el proyecto Symfony
Ejecutar para poder acceder al terminal:
```
sudo docker exec -it php bash
```
Y luego, dentro del contenedor ***php***
```
composer install
```
Y realizar las migraciones de la BD pertinentes:
```
bin/console doctrine:migrations:migrate
```