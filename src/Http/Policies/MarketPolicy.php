<?php

namespace Market\Http\Policies;

use App\Models\User;

/**
 * Class MarketPolicy.
 *
 * @package Finder\Http\Policies
 */
class MarketPolicy
{
    /**
     * Create a market.
     *
     * @param  User   $authUser
     * @param  string $marketClass
     * @return bool
     */
    public function create(User $authUser, string $marketClass)
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        return false;
    }

    /**
     * Get a market.
     *
     * @param  User  $authUser
     * @param  mixed $market
     * @return bool
     */
    public function get(User $authUser, $market)
    {
        return $this->hasAccessToMarket($authUser, $market);
    }

    /**
     * Determine if an authenticated user has access to a market.
     *
     * @param  User $authUser
     * @param  $market
     * @return bool
     */
    private function hasAccessToMarket(User $authUser, $market): bool
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        if ($market instanceof User && $authUser->id === optional($market)->id) {
            return true;
        }

        if ($authUser->id === optional($market)->created_by_user_id) {
            return true;
        }

        return false;
    }

    /**
     * Update a market.
     *
     * @param  User  $authUser
     * @param  mixed $market
     * @return bool
     */
    public function update(User $authUser, $market)
    {
        return $this->hasAccessToMarket($authUser, $market);
    }

    /**
     * Delete a market.
     *
     * @param  User  $authUser
     * @param  mixed $market
     * @return bool
     */
    public function delete(User $authUser, $market)
    {
        return $this->hasAccessToMarket($authUser, $market);
    }
}
