<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $request['image_url'] = '';
        if ($request->user_img) {
            $base64_str = substr($request->user_img, strpos($request->user_img, ",") + 1);
            $image = base64_decode($base64_str);
            Storage::disk('local')->put('public/' . $user->id . '.png', $image);
            $request['image_url'] = Storage::url($user->id . '.png') . '?v=' . time();
        }

        $user->update($request->only('name', 'email', 'image_url'));

        return response()->json($user);
    }


}
