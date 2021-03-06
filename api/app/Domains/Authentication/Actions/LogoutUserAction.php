<?php

namespace App\Domains\Authentication\Actions;

use App\Domains\Authentication\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LogoutUserAction
{
    public function run(User $user): void
    {
        $user->tokens
            ->each(function ($token, $key) {
                $this->revokeAccessAndRefreshTokens($token->id);
            });
    }

    protected function revokeAccessAndRefreshTokens($tokenId): void
    {
        /** @var TokenRepository */
        $tokenRepository = app('Laravel\Passport\TokenRepository');
        /** @var RefreshTokenRepository */
        $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }
}
