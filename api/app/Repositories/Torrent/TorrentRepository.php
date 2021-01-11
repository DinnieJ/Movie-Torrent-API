<?php

namespace App\Repositories\Torrent;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Torrent;

class TorrentRepository extends BaseRepository implements TorrentRepositoryInterface
{
    public function model()
    {
        return Torrent::class;
    }
}
