#instalacja obrazu serwera nginx w wersji 1.17.8-alpine
FROM nginx:1.17.8-alpine

#kopiowanie całej struktrury projektu do folderu na serwerze nginx
COPY . /app/
#kopiowanie pliku konfiugracyjnego do serwera ngnix zainstalowanego w wirtualnym obrazie kontenera
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf