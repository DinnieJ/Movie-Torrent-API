<?php

namespace App\Client;

use Illuminate\Support\Facades\Http;

trait ClientHandler
{
    public function getMoviesFromServer($page, $limit)
    {
        $url = 'https://yts.mx/api/v2/list_movies.json' .
                '?limit=' . $limit .
                '&page=' . $page;
        $response = Http::get($url);
        $movies = \json_decode($response->body())->data->movies;

        return $movies;
    }

    public function getPage($limit)
    {
        // $url = 'https://yts.mx/api/v2/list_movies.json';
        // $response = Http::get($url);
        // return \ceil(\json_decode($response->body())->data->movie_count / $limit);
        return 10;
    }
}
