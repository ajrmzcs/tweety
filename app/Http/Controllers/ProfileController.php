<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'user' => $user,
            'tweets' => $user->tweets()->paginate(50),
        ]);
    }

    public function edit(User $user)
    {
//        if ($user->isNot(current_user())) {
//            abort(404);
//        }

//        abort_if($user->isNot(current_user()), 404);

//        $this->authorize('edit', $user);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'username' => [
                'string',
                'required',
                'alpha_dash',
                'max:255',
                Rule::unique('users')->ignore($user)
            ],
            'avatar' => [
              'file'
            ],
            'name' => [
                'string',
                'required',
                'max:255'
            ],
            'email' => [
                'string',
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user)
            ],
            'password' => [
                'required',
                'min:8',
                'max:255',
                'confirmed'
            ]
        ]);

        if (request('avatar')) {
            $attributes['avatar'] = request('avatar')->store('avatars');
        }

        $user->update($attributes);

        return redirect($user->path());
    }
}
