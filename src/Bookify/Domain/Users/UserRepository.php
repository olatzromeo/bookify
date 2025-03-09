<?php

namespace Bookify\Domain\Users;

interface UserRepository
{
    public function getById(string $id): ?User;

    public function save(User $user): void;
}
