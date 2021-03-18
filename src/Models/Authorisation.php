<?php

namespace Rvsitebuilder\Marketing\Models;

/*
 * Holds Google API authorisations.
 *
 * Data columns:
 *
 * + user_id - the laravel user who created/owns the authorisation.
 * + access_token - the current active token
 * + refresh_token - the long-term token for refreshing the auth token
 * + created_time - the (local) time the token was created (unix timestamp, integer)
 * + expires_in - the time after the created_time that the token will expire, in seconds
 * + state - auth, active, inactive
 * + scope - the current scope that has been authorised
 */

//use Illuminate\Database\Eloquent\Model;
//use Academe\GoogleApi\Helper;
use Exception;
use Google_Client;
use Google_Service_Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Lib\Vendor\GoogleAPI\Helper;

class Authorisation extends Model
{
    // The status values.
    public const STATE_AUTH = 'auth';

    public const STATE_ACTIVE = 'active';

    public const STATE_INACTIVE = 'inactive';

    // The name if name of the authorisation provided.
    public const DEFAULT_NAME = 'default';

    public $timestamps = false;

    protected $table = 'gapi_authorisations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'name',
        'state',
        'access_token',
        'refresh_token',
        'created_time',
        'expires_in',
        'scope',
        'google_user_id',
        'google_email',
    ];

    protected $base_scopes = ['openid', 'email'];

    /**
     * Google_Client.
     */
    protected $google_client;

    /**
     * Get the Google API client.
     *
     * @param bool $use_default use the defaukt client from the Helper
     */
    public function getApiClient($use_default = false)
    {
        $client = $this->google_client;

        if (empty($client) && $use_default) {
            $client = Helper::getApiClient($this);

            $this->setApiClient($client);
        }

        return $client;
    }

    public function setApiClient(Google_Client $client): self
    {
        $this->google_client = $client;

        return $this;
    }

    public function scopeOwner($query, $userId)
    {
        return $query
            ->where('user_id', '=', $userId)
            ->orderBy('id');
    }

    public function scopeName($query, $name)
    {
        return $query
            ->where('name', '=', (!empty($name) ? trim($name) : static::DEFAULT_NAME));
    }

    public function scopeCurrentUser($query)
    {
        return $this->owner(Auth::id());
    }

    public function scopeIsAuthorising($query)
    {
        return $query->where('state', '=', self::STATE_AUTH);
    }

    public function scopeIsActive($query)
    {
        return $query->where('state', '=', static::STATE_ACTIVE);
    }

    public function scopeIsInactive($query)
    {
        return $query->where('state', '=', static::STATE_INACTIVE);
    }

    public function getJsonTokenAttribute()
    {
        $token = [
            'access_token' => $this->access_token,
            'token_type' => 'Bearer',
            'expires_in' => $this->expires_in,
        ];

        if ($this->refresh_token) {
            $token['refresh_token'] = $this->refresh_token;
        }

        $token['created'] = $this->created_time;

        return json_encode($token);
    }

    public function setJsonTokenAttribute($value): void
    {
        if (\is_string($value)) {
            $value = json_decode($value, true);
        }

        // TODO: error if not an array.

        $this->attributes['access_token'] = Arr::get($value, 'access_token');
        $this->attributes['refresh_token'] = Arr::get($value, 'refresh_token');
        $this->attributes['created_time'] = Arr::get($value, 'created');

        // Here I am very very tempted to knock five minutes off the expires_in
        // period to make sure we don't operate close to the line. Having a token
        // expire in the middle of a bunch of processing is a pain to deal with,
        // so renew early to try to help there. That's a *configurable* five
        // minutes, of course. [DONE]

        $this->attributes['expires_in'] = Arr::get($value, 'expires_in', 3600)
            - Config('googleapi.expires_in_safety_margin', 0);
    }

    public function setIdTokenAttribute($value): void
    {
        if (\is_array($value)) {
            $this->attributes['google_user_id'] = Arr::get($value, 'sub', $this->google_user_id);
            $this->attributes['google_email'] = Arr::get($value, 'email', $this->google_email);
        }
    }

    public function getScopesAttribute()
    {
        if ($array = json_decode($this->scope, true)) {
            return $array;
        }

        return [];
    }

    public function setScopesAttribute(array $value): void
    {
        $this->attributes['scope'] = json_encode($value);

        // Add the base scopes.
        $this->addScope($this->base_scopes);
    }

    public function addScope($scopes): void
    {
        foreach ((array) $scopes as $scope) {
            if (!$this->hasScope($scope)) {
                $this->scopes = array_merge($this->scopes, [$scope]);
            }
        }
    }

    public function hasScope($scope): bool
    {
        return \in_array($scope, $this->scopes, true);
    }

    /**
     * Initialise the record for a new authorisation.
     */
    public function initAuth(): void
    {
        $this->state = static::STATE_AUTH;
        $this->access_token = null;
        $this->refresh_token = null;
        $this->created_time = null;
        $this->expires_in = null;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('googleapi.user_model'));
    }

    public function isActive(): bool
    {
        return $this->state === static::STATE_ACTIVE;
    }

    /**
     * Revoke the record for a new authorisation.
     * TODO: Once revoked, we should also go through other authorisations
     * for this Laravel user and Google account to revoke those too.
     * Similarly when an authorisation is successful, go through other active
     * authorisations for that Laravel and Google user, and.
     */
    public function revokeAuth(): bool
    {
        if ($this->isActive() && $this->access_token) {
            // Start by revoking the access token with Google.
            // See SO example:
            // https://stackoverflow.com/questions/31515231/revoke-google-access-token-in-php
            // Q: Does this remove the refresh token too?

            $client = $this->getApiClient(true);

            // Revoke the token with Google.
            $client->revokeToken($this->access_token);

            // Now remove details of the token we have stored.
            // CHECKME: should we keep the refresh token? Can that possibly still be be
            // used? It is not cleat whether revoking only happens to the access token,
            // or whether the refresh token is also revoked.

            $this->state = static::STATE_INACTIVE;
            $this->access_token = null;
            $this->refresh_token = null;
            $this->created_time = null;
            $this->expires_in = null;

            // Save the rusultant state.
            $this->save();

            return true;
        }

        return false;
    }

    /**
     * Refresh a token.
     */
    public function refreshToken(): bool
    {
        // A refresh token is needed to renew.
        if (empty($this->refresh_token)) {
            return false;
        }

        $client = $this->getApiClient(true);

        // Renew the token with Google.
        $client->refreshToken($this->refresh_token);

        // Capture the renewed token details: access token, expirey etc. are
        // all set at once.
        $this->json_token = $client->getAccessToken();

        // Save the rusultant state.
        $this->save();

        return true;
    }

    /**
     * Tests a token to see that it still works.
     */
    public function testToken(): bool
    {
        // If not marked as active, then don't even attempt to access the
        // remote service.

        if (!$this->isActive()) {
            throw new Exception('Authorisation is marked as inactive.');
        }

        $client = $this->getApiClient(true);

        $oauth2 = new \Google_Service_Oauth2($client);

        try {
            $userinfo = $oauth2->userinfo->get();
        } catch (Google_Service_Exception $e) {
            // If the error is a 401, we will try renewing the token manually,
            // just once, to see if that fixes the problem.

            try {
                if ($e->getCode() == 401 && $this->refreshToken()) {
                    // Try accessing the API again.

                    $userinfo = $oauth2->userinfo->get();

                    return true;
                }
            } catch (Google_Service_Exception $e) {
                // Still in error. Mark this authorisation as inactive.

                $this->state = static::STATE_INACTIVE;
                $this->save();
            }

            // Renewal did not work, so throw the reason.
            throw $e;
        }

        return true;
    }
}
