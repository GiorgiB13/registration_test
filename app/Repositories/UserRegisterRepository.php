<?php

namespace App\Repositories;

use App\Events\UserRegisteredEvent;
use App\Models\Country;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRegisterRepository
{
    public function register(object $userData): void
    {
        $user = User::firstOrCreate([
            'name' => $userData->name,
            'email' => $userData->email,
        ]);

        $phone = Phone::firstOrCreate([
           'phone_number' => $userData->phone,
        ]);

        $country = Country::firstOrCreate([
            'name' => $userData->country,
        ]);

        $user->phones()->attach($phone->id);
        $user->countries()->attach($country->id);

        DB::beginTransaction();

        try {
            $user = User::firstOrCreate([
                'name' => $userData->name,
                'email' => $userData->email,
            ]);

            $phone = Phone::firstOrCreate([
                'phone_number' => $userData->phone,
            ]);

            $country = Country::firstOrCreate([
                'name' => $userData->country,
            ]);

            $user->phones()->attach($phone->id);
            $user->countries()->attach($country->id);

            DB::commit();

        } catch (\Exception){
            DB::rollBack();
        }

        event(new UserRegisteredEvent($user));
    }
}
