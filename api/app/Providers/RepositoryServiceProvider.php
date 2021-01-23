<?php

namespace App\Providers;

use App\Repositories\Car\CarRepository;
use App\Repositories\Car\CarRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\Torrent\TorrentRepositoryInterface;
use App\Repositories\Torrent\TorrentRepository;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\Favorite\FavoriteRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $repositories = [
            [
                MovieRepository::class,
                MovieRepositoryInterface::class
            ],
            [
                TorrentRepository::class,
                TorrentRepositoryInterface::class
            ],
            [
                FavoriteRepository::class,
                FavoriteRepositoryInterface::class
            ],
            [
                CarRepository::class,
                CarRepositoryInterface::class
            ]
        ];

        foreach ($repositories as $repo) {
            $this->app->singleton($repo[1], $repo[0]);
        }
    }
}
