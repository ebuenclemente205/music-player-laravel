<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Collection;

class PlaylistService
{
    public function getSongsFromPlaylist(Playlist $playlist): Collection
    {
        return $playlist->songs()->get();
    }
}
