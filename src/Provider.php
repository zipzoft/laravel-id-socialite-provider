<?php namespace Zipzoft\ID;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\ConfigTrait;
use Laravel\Socialite\Two\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    use ConfigTrait;

    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'zipzoft';

    /**
     * @var string
     */
    const GRAPH_URL = 'https://id.zipzoft.online';

    /**
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * Default scopes
     *
     * @var string[]
     */
    protected $scopes = [
        'public-profile',
        'email',
    ];

    /**
     * Get the authentication URL for the provider.
     *
     * @param string $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getEndpoint().'/oauth/authorize', $state);
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->getEndpoint().'/oauth/token';
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param string $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $meUrl = $this->getEndpoint().'/api/v1/me';

        $response = $this->getHttpClient()->get($meUrl, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
        ]);

        return json_decode($response->getBody(), true)['data'];
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param array $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => null,
            'name' => $user['name'] ?? null,
            'email' => $user['email'] ?? null,
            'avatar' => null,
            'avatar_original' => null,
            'profileUrl' => null,
        ]);
    }


    /**
     * Get the authentication URL for the provider.
     *
     * @param  string  $url
     * @param  string  $state
     * @return string
     */
    protected function buildAuthUrlFromBase($url, $state)
    {
        return $url.'?'.http_build_query($this->getCodeFields($state), '', '&', $this->encodingType);
    }

    /**
     * @param string $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
            'grant_type' => 'authorization_code',
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator)
        ];
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return static::GRAPH_URL;
    }
}
