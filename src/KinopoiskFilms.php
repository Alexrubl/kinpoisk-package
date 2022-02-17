<?php

namespace Queen\KinopoiskPackage;

use Exception;

class KinopoiskFilms
{
    //версия api
    const VERSION = 'v2.2';
    //метод api
    const FILMS = 'films';

    //типы запросов
    const TYPE_FACTS = 'facts';
    const TYPE_VIDEOS = 'videos';
    const TYPE_TOP = 'top';
    const TYPE_PREMIERES = 'premieres';
    const TYPE_IMAGES = 'images';
    const TYPE_SEARCH_BY_KEYWORD = 'search-by-keyword';

    //топы Кинопоиска
    const TOP_250_BEST_FILMS = 'TOP_250_BEST_FILMS';
    const TOP_100_POPULAR_FILMS = 'TOP_100_POPULAR_FILMS';
    const TOP_AWAIT_FILMS = 'TOP_AWAIT_FILMS';

    //типы изображений
    const STILL = 'STILL';           //кадры
    const SHOOTING = 'SHOOTING';     //изображения со съемок
    const POSTER = 'POSTER';         //постеры
    const FAN_ART = 'FAN_ART';       //фан-арты
    const PROMO = 'PROMO';           //промо
    const CONCEPT = 'CONCEPT';       //концепт-арты
    const WALLPAPER = 'WALLPAPER';   //обои
    const COVER = 'COVER';           //обложки
    const SCREENSHOT = 'SCREENSHOT'; //скриншоты

    private string $url = 'https://kinopoiskapiunofficial.tech/api/';
    private string $apiKey = '';

    /**
     * @throws Exception
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function api($id = null, $asArray = false, $type = null, $params = [])
    {
        $url = $this->url . self::VERSION . '/' . static::FILMS;

        if (!empty($id)) {
            $url .= '/' . $id;
        }

        if (!empty($type)) {
            $url .= '/' . $type;
        }

        if ($params) {
            $url .= '/' . '?' . http_build_query($params);
        }

        $headers = [];
        $headers[] = "X-API-KEY: {$this->apiKey}";
        $headers[] = 'Content-Type: application/json';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        return json_decode(curl_exec($curl), $asArray);
    }

    /**
     * Получить основную информацию о фильме по его id на сайте Кинопоиск
     *
     * @param int $id
     * @param bool $asArray
     *
     * @return mixed
     */
    public function getFilmInfoById(int $id, bool $asArray = false)
    {
        return $this->api($id, $asArray);
    }

    /**
     * Получить интересные факты о фильме по его id на сайте Кинопоиск
     *
     * @param int $id
     * @param bool $asArray
     *
     * @return mixed
     */
    public function getFilmFacts(int $id, bool $asArray = false)
    {
        return $this->api($id, $asArray, static::TYPE_FACTS);
    }

    /**
     * Получить трейлеры и тизеры фильма по его id на сайте Кинопоиск
     *
     * @param int $id
     * @param bool $asArray
     *
     * @return mixed
     */
    public function getFilmTrailers(int $id, bool $asArray = false)
    {
        return $this->api($id, $asArray, static::TYPE_VIDEOS);
    }

    /**
     * Получить ТОП фильмов
     *
     * @param string|null $topType
     * @param int $page
     * @param bool $asArray
     *
     * @return mixed
     */
    public function getTop(string $topType = self::TOP_250_BEST_FILMS, int $page = 1, bool $asArray = false)
    {
        $params = null;
        if (!empty($topType)) {
            $params = [
                'type' => $topType,
                'page' => $page,
            ];
        }
        return $this->api(null, $asArray, static::TYPE_TOP, $params);
    }


    /**
     * Найти фильм по ключевому слову
     *
     * @param string $keyword
     * @param int $page
     * @param bool $asArray
     *
     * @return false|mixed
     * @throws Exception
     */
    public function searchFilmByKeyword(string $keyword, int $page = 1, bool $asArray = false)
    {
        try {
            $params = [
                'keyword' => $keyword,
                'page' => $page,
            ];
            return $this->api(null, $asArray, static::TYPE_SEARCH_BY_KEYWORD, $params);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Получить премьеры фильмов по заданному году и месяцу
     *
     * @param int $year
     * @param string $month
     * @param bool $asArray
     *
     * @return mixed
     * @throws Exception
     */
    public function getPremieres(int $year, string $month, bool $asArray = false)
    {
        try {
            $params = [
                'year' => $year,
                'month' => $month,
            ];
            return $this->api(null, $asArray, static::TYPE_PREMIERES, $params);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Получить различные типы изображений по id фильма на Кинопоиске
     *
     * @param int $id
     * @param bool $asArray
     * @param string $imageType
     * @param int $page
     *
     * @return mixed|string
     */
    public function getImages(int $id, bool $asArray = false, string $imageType = self::POSTER, int $page = 1)
    {
        try {
            $params = [
                'type' => $imageType,
                'page' => $page
            ];
            return $this->api($id, $asArray, static::TYPE_IMAGES, $params);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
