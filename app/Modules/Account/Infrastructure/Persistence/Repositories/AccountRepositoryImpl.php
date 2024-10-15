<?php

namespace App\Modules\Account\Infrastructure\Persistence\Repositories;

use App\Modules\Account\Domains\Repositories\AccountRepository;
use App\Modules\Account\Infrastructure\Persistence\Models\User;
use App\Shared\Repositories\RepositoryImpl;

class AccountRepositoryImpl extends RepositoryImpl implements AccountRepository
{
    public function model()
    {
        return new User::class;
    }
}
