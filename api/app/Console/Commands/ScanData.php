<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Torrent\TorrentRepositoryInterface;
use App\Client\ClientHandler;
use App\Models\Movie;
use App\Models\Torrent;

class ScanData extends Command
{
    use ClientHandler;

    protected $movieRepository;
    protected $torrentRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scanning data to db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        MovieRepositoryInterface $movieRepository,
        TorrentRepositoryInterface $torrentRepository
    ) {
        parent::__construct();
        $this->movieRepository = $movieRepository;
        $this->torrentRepository = $torrentRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Delete from database...');
        Torrent::truncate();
        Movie::truncate();
        $this->info('Scanning data from yts...');
        $limit = 50;
        $count = $this->getPage($limit) - 1;
        $this->info('Total page: ' . $count);
        
        for ($page = 1; $page <= $count; $page++) {
            $movies = $this->getMoviesFromServer($page, $limit) ?? [];

            foreach ($movies as $movie) {
                $newMovie = $this->movieRepository->create([
                    'title' => $movie->title,
                    'title_eng' => $movie->title_english,
                    'year' => $movie->year,
                    'rating' => $movie->rating,
                    'description' => $movie->description_full,
                    'background_img' => $movie->background_image,
                    'cover_img' => $movie->medium_cover_image,
                    'url' => $movie->url,
                    'source_movie_id' => $movie->id,
                    'source' => 'yts'
                ]);
                $torrents = $movie->torrents ?? [];
                foreach ($torrents as $torrent) {
                    $this->torrentRepository->create([
                        'movie_id' => $newMovie->movie_id,
                        'url' => $torrent->url,
                        'hash' => $torrent->hash,
                        'quality' => $torrent->quality,
                        'type' => $torrent->type,
                        'size' => $torrent->size_bytes,
                        'date_uploaded' => $torrent->date_uploaded_unix
                    ]);
                }
                $this->info('Added: ' . $newMovie->title);
            }
        }
    }
}
