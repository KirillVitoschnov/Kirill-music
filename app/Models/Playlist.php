<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';

    public function musics()
    {
        return $this->belongsToMany(Music::class, 'playlist_music');
    }
}
