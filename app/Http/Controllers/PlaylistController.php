<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getSongsFromPlaylist(Request $request, $playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);
        $songs = $this->playlistService->getSongsFromPlaylist($playlist);

        return $this->successResponse(SongResource::collection($songs));
    }
}
