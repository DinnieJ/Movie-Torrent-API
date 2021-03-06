<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\Torrent\TorrentRepositoryInterface;
use App\Repositories\Torrent\TorrentRepository;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\CommentRepositoryInterface;

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
                CommentRepository::class,
                CommentRepositoryInterface::class
            ]
        ];

        foreach ($repositories as $repo) {
            $this->app->singleton($repo[1], $repo[0]);
        }
    }
}
