<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Auth;

interface UserIdVerifierInterface
{
    public function verify(string $id): bool;
}
