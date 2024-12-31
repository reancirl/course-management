<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // Conditionally add the current_password validation if it exists
        $rules = [
            'password' => $this->passwordRules(),
        ];

        if (!empty($user->password)) {
            $rules['current_password'] = ['required', 'string', 'current_password:web'];
        }

        // Validate the input
        Validator::make($input, $rules, [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validateWithBag('updatePassword');

        // Update the user's password
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}