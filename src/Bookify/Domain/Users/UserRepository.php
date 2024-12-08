<?php

namespace Bookify\Domain\Users;

interface UserRepository
{
    public function getById(string $id): User | null;

    public function add(User $user): void;
}
