<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Collection;

class PlaylistService
{
    public function getRandomSongs(Playlist $playlist, array $playedSongs, $limit = 8): Collection
    {
        $songs = $playlist->songs()->get();

        // Filter out already played songs
        $unplayedSongs = $songs->whereNotIn('id', $playedSongs);

        // If no unplayed songs left, reset played songs array (handled in controller)
        if ($unplayedSongs->isEmpty()) {
            return collect(); // Return an empty collection to signal the controller to reset
        }

        $filteredSongs = $this->filterSameArtistSongs($unplayedSongs, $playedSongs);

        // If no songs remain after filtering, fallback to the unfiltered set
        if ($filteredSongs->isEmpty()) {
            $filteredSongs = $unplayedSongs;
        }

        return $filteredSongs->shuffle()->take($limit);
    }

    protected function filterSameArtistSongs(Collection $songs, array $playedSongs): Collection
    {
        if (empty($playedSongs)) {
            return $songs;
        }

        $lastPlayedSong = Song::find(end($playedSongs));

        return $songs->filter(function ($song) use ($lastPlayedSong) {
            return $song->artist !== $lastPlayedSong->artist;
        });
    }

    public function getSongsFromPlaylist(Playlist $playlist): Collection
    {
        return $playlist->songs()->get();
    }
}
