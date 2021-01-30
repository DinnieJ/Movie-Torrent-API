<?php

namespace App\Repositories\Movie;

interface MovieRepositoryInterface
{
    public function getTopFiveMovies();

    public function searchMoviesByQuery($query);

    public function getPageNumber();

    public function getMovieCardAuth($userId);

    public function getMovieByTitle($title);
}
