<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    /**
     * Show the password change form.
     */
    public function index()
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's password and mark as verified.
     */
    public function update(ChangePasswordRequest $request, #[CurrentUser] User $user)
    {
        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        $user->markEmailAsVerified();

        return to_route('members.index')
            ->with('success', 'Password changed successfully!');
    }
}
