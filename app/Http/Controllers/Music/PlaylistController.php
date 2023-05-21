<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\PlaylistMusic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;

class PlaylistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $playlists = Playlist::where('user_id', $user->id)
            ->with(['musics' => function ($query) {
                $query->latest();
            }])
            ->withCount('musics')
            ->latest()
            ->get();

        return response()->json(['music' => $playlists], 200);
    }


    public function store(Request $request)
    {
        $playlist = new Playlist();
        $playlist->user_id = Auth::id();
        $playlist->name = $request->name;
        $playlist->save();
        return redirect()->back()->with('success', 'Playlist created successfully');
    }

    public function addMusic(Request $request)
    {
        $playlist_id = $request->input('playlist_id');
        $user = Auth::user();
        $playlist = Playlist::where('id', $playlist_id)->where('user_id', $user->id)->first();

        if (!$playlist) {
            return redirect()->back()->with('error', 'Playlist not found');
        }

        $music_id = $request->input('music_id');
        $playlist_music = new PlaylistMusic;
        $playlist_music->playlist_id = $playlist->id;
        $playlist_music->music_id = $music_id;
        $playlist_music->save();

        return redirect()->back()->with('success', 'Music added to playlist');
    }

    public function show($id)
    {
        $playlist = Playlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $musics = $playlist->musics()->get();

        return response()->json(['music' => $musics], 200);
    }
}
