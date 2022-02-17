# Kinopoisk-package

Composer-пакет для получения информации о фильмах с сайта Кинопоиск. 
Создан в учебных целях в рамках курса "PHP Developer Professional" на учебной платформе Otus.

## Installation

Подключение пакета при помощи пакетного менеджера Composer.

```bash
composer require julia-queen/kinopoisk-package
```

## Usage
Перед началом использования необходимо получить ApiKey на сайте [Kinopoisk Api Unofficial](https://kinopoiskapiunofficial.tech/)

```php
// вернет ссылки на постеры
$apiKey = 'your apiKey';
$filmApi = new KinopoiskFilms($apiKey);
$filmApi->getImages($id);

//вернет общую информацию о фильме по его id
$filmApi->getFilmInfoById($id)
```
Для получения списка премьер фильмов по году и месяцу необходимо использовать перечисление ```src/Enums/MonthEnum.php```

Также доступны методы получения интересных фактов о фильме, получение ТОП фильмов, получение трейлеров, получение премьер фильмов за выбранный месяц и год

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
