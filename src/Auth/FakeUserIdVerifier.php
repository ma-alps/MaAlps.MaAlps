<?php

declare(strict_types=1);

namespace MaAlps\MaAlps\Auth;

class FakeUserIdVerifier implements UserIdVerifierInterface
{
    public function verify(string $id): bool
    {
        return true;
    }
}
