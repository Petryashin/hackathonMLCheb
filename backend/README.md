# BACKEND

Backend выполнен на языке программирования РНР с использованием фреймворка Laravel.
Backend реализует следующий функционал:
- API для загрузки и обработки датасета после "preprocessing", а также обработка результатов предсказания модели ML
- Клиент для обмена данными с Frontend приложением

# Важные моменты:
- Выполнен парсинг геометок по текстовым представлениям адресов с помощью сервиса
https://nominatim.openstreetmap.org/search      
Для стабильности работы применялось задание очереди - Jobs
- Сборка Backend выполнена с использованием контейнеризации Docker