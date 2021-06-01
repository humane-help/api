<?php

namespace App\Models\Passport;

use Laravel\Passport\Client as BaseClient;

/**
 * Class Client
 * @package App\Models\Passport
 */
class Client extends BaseClient
{
    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }
}
