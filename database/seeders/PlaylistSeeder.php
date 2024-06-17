<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some songs
        $songs =  [
            ['artist' => 'Ed Sheeran', 'title' => 'Shape of You'],
            ['artist' => 'Billie Eilish', 'title' => 'Bad Guy'],
            ['artist' => 'Post Malone', 'title' => 'Circles'],
            ['artist' => 'Taylor Swift', 'title' => 'Shake It Off'],
            ['artist' => 'The Weeknd', 'title' => 'Blinding Lights'],
            ['artist' => 'Ed Sheeran', 'title' => 'Photograph'],
            ['artist' => 'Adele', 'title' => 'Rolling in the Deep'],
            ['artist' => 'Post Malone', 'title' => 'Sunflower']
        ];

        foreach ($songs as $songData) {
            Song::create($songData);
        }

        // Seed some playlists with songs attached
        $playlists = [
            [
                'name' => 'My Playlist',
                'songs' => [1, 2, 3, 4, 5, 6, 7, 8],
            ],
        ];

        foreach ($playlists as $playlistData) {
            $playlist = Playlist::create(['name' => $playlistData['name']]);
            $playlist->songs()->attach($playlistData['songs']);
        }
    }
}
