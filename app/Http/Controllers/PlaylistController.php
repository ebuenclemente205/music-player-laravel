<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Playlist;
use App\Services\PlaylistService;
use App\Http\Resources\SongResource;

class PlaylistController extends Controller
{
    protected $playlistService;

    public function __construct(PlaylistService $playlistService)
    {
        $this->playlistService = $playlistService;
    }

    public function getRandomSongs(Request $request, $playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);
        $playedSongs = Session::get('played_songs', []);

        $randomSongs = $this->playlistService->getRandomSongs($playlist, $playedSongs);

        if ($randomSongs->isEmpty()) {
            // Reset the played songs if all songs have been played
            $playedSongs = [];
            $randomSongs = $this->playlistService->getRandomSongs($playlist, $playedSongs);
        }

        // Update the session with the newly played songs
        $playedSongs = array_merge($playedSongs, $randomSongs->pluck('id')->toArray());
        Session::put('played_songs', $playedSongs);
        
        return $this->successResponse(SongResource::collection($randomSongs));
    }

    public function getSongsFromPlaylist(Request $request, $playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);
        $songs = $this->playlistService->getSongsFromPlaylist($playlist);

        return $this->successResponse(SongResource::collection($songs));
    }
}
