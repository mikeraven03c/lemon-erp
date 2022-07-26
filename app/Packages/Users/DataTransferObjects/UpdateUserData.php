<?php

namespace App\Packages\Users\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Illuminate\Support\Facades\Hash;

class UpdateUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {
    }

    public static function fromAPI(Request $request)
    {
        return new self(
           $request['name'],
           $request['email'],
           Hash::make('mikeerp_1234#')
        );
    }
}
