<?php

namespace App\Modules\Account\Infrastructure\Persistence\Repositories;

use App\Modules\Account\Domains\Repositories\UserRepository;
use App\Modules\Account\Infrastructure\Persistence\Models\User;
use App\Shared\Repositories\RepositoryImpl;

class UserRepositoryImpl extends RepositoryImpl implements UserRepository
{
    public function model()
    {
        return new User::class;
    }
}
