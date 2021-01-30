<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client\ClientHandler;

class TorrentController extends Controller
{
    use ClientHandler;

    private $torrentRepository;

    public function __construct(
        TorrentRepositoryInterface $torrentRepository
    ) {
        parent::__construct();
        $this->torrentRepository = $torrentRepository;
    }

    public function downloadTorrent(Request $request)
    {
    }
}
