# Препроцессинг данных с OSM
В этой папке содержится скрипт предподготовки данных с карты OSM. Исходные данные -- выгрузка из OSM по ПФО. Фильтрация происходит при помощи набора приложений osmfilter https://wiki.openstreetmap.org/wiki/Osmfilter. На основании выгрузки и полигона cheb.poly происходит выборка данных.  
Промежуточные данные -- 3 файла: filtered_parkings, _parks и _school с парковками, парками и школами соответственно.  
Исходный код, преобразующий данные из репозитория находится в файле parse_osm.ipynb  

Исходные данные доступны на странице  https://download.geofabrik.de/russia.html  
Прямая сссылка на исходный файл  https://download.geofabrik.de/russia/volga-fed-district-latest.osm.bz2