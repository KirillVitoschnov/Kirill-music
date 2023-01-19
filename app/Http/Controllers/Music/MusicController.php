<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;

use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Owenoj\LaravelGetId3\GetId3;

class MusicController extends Controller
{
    public function index()
    {
        $music = Music::paginate(100);
        return response()->json(['music' => $music], 200);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'music' => 'required|file|mimetypes:audio/mpeg,audio/x-m4a,audio/mp3',
        ]);
        $track = new GetId3(request()->file('music'));
        $path = $request->file('music')->store('public/music');
        $music = new Music;
        $music->user_id=auth()->user()->id;
        $music->path = str_replace('public', '', $path);
        $music->title = $track->getTitle();
        $music->artist = $track->getArtist();
        $music->seconds = $track->getPlaytimeSeconds();
        if ($track->getArtwork()) {
            $path = $track->getArtwork(true)->store('public/music-logos');
            $music->logo = str_replace('public', '', $path);;
        } else {
            $music->logo = null;
        }

        $music->genres = json_encode($track->getGenres());

        $music->save();

        return response()->json(['message' => 'Music uploaded successfully', 'path' => $path], 200);
    }
}
