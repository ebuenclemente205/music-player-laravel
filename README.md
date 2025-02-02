
# Laravel Music Project

## Packages

This project uses the following packages:

-   laravel/breeze: ^2.0
    
-   laravel/sail: ^1.26
    
-   laravel/sanctum: ^4.0
    

## Getting Started

This project uses Docker for development. To get started, simply run the following command:

```
docker-compose up
```

This will start the Docker container and make the application available at [http://localhost:8000](http://localhost:8000/).

## Troubleshooting

If you encounter any issues with the application, please check the Laravel logs for errors. You can also try running the following command to clear the cache and restart the application:

docker-compose exec app php artisan cache:clear docker-compose exec app php artisan optimize

## Random Song Playback Feature

This project implements a random song playback feature that ensures songs are not repeated consecutively and also avoids playing songs from the same artist consecutively.

## Backend Implementation

### PlaylistController

The `PlaylistController` class is responsible for handling requests related to playlists. In this case, it implements a `getRandomSongs` method that returns a random set of songs from a given playlist.

```
1public function getRandomSongs(Request $request, $playlistId)
2{
3    $playlist = Playlist::findOrFail($playlistId);
4    $playedSongs = Session::get('played_songs', []);
5
6    $randomSongs = $this->playlistService->getRandomSongs($playlist, $playedSongs);
7
8    if ($randomSongs->isEmpty()) {
9        // Reset the played songs if all songs have been played
10        $playedSongs = [];
11        $randomSongs = $this->playlistService->getRandomSongs($playlist, $playedSongs);
12    }
13
14    // Update the session with the newly played songs
15    $playedSongs = array_merge($playedSongs, $randomSongs->pluck('id')->toArray());
16    Session::put('played_songs', $playedSongs);
17    
18    return $this->successResponse(SongResource::collection($randomSongs));
19}
```

### PlaylistService

The `PlaylistService` class is responsible for handling the business logic related to playlists. In this case, it implements a `getRandomSongs` method that returns a random set of songs from a given playlist, while ensuring that songs are not repeated consecutively and also avoiding playing songs from the same artist consecutively.

```
1public function getRandomSongs(Playlist $playlist, array $playedSongs, $limit = 8): Collection
2{
3    $songs = $playlist->songs()->get();
4
5    // Filter out already played songs
6    $unplayedSongs = $songs->whereNotIn('id', $playedSongs);
7
8    // If no unplayed songs left, reset played songs array (handled in controller)
9    if ($unplayedSongs->isEmpty()) {
10        return collect(); // Return an empty collection to signal the controller to reset
11    }
12
13    $filteredSongs = $this->filterSameArtistSongs($unplayedSongs, $playedSongs);
14
15    // If no songs remain after filtering, fallback to the unfiltered set
16    if ($filteredSongs->isEmpty()) {
17        $filteredSongs = $unplayedSongs;
18    }
19
20    return $filteredSongs->shuffle()->take($limit);
21}
```