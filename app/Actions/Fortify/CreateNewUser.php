<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'role_id' => ['required', 'exists:roles,id'],
            'location_id' => ['required', 'not_in:0', 'exists:locations,id']
        ], [
            'name.required' => 'Ime je obavezno.',
            'name.max' => 'Ime je predugačko.',
            'email.required' => 'Email je obavezan.',
            'email.email' => 'Email nije dobrog formata.',
            'email.max' => 'Email je predugačak.',
            'email.unique' => 'Email već postoji.',
            'password.required' => 'Lozinka je obavezna.',
            'password.confirmed' => 'Potvrda lozinka se ne podudara sa lozinkom.',
            'password.min' => 'Lozinka mora biti bar 8 karaktera.',
            'role_id.required' => 'Uloga je obavezna.',
            'role_id.not_in' => 'Uloga nije izabrana.',
            'role_id.exists' => 'Uloga ne postoji u bazi.',
            'location_id.required' => 'Lokacija je obavezna.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.'

        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => $input['role_id'],
            'location_id' => $input['location_id']
        ]);
    }
}
