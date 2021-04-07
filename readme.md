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

## Ejecución script carga de productos
El programa funciona a través de una ejecución de comando a través de terminal. De este modo se le puede
asignar un cronjob para que se ejecute periódicamente. El comando funciona del siguiente modo:
```
bin/console app:check-products url
```
En la url hay que indicar una URL válida que devuelva cualquiera de los 3 archivos con los que podemos tratar (XML, json y xlxs).