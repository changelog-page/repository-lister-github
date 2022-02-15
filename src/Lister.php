<?php

declare(strict_types=1);

namespace Changelog\RepositoryLister\GitHub;

use Changelog\Hydrator\HydratesResources;
use Changelog\RepositoryLister\Lister as Contract;
use Github\AuthMethod;
use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

final class Lister implements Contract
{
    use HydratesResources;

    private Client $client;

    public function __construct(array $credentials)
    {
        $this->client = new Client();
        $this->client->authenticate($credentials['token'], null, AuthMethod::ACCESS_TOKEN);
    }

    public function byUser(string $uuid, ?array $options): Collection
    {
        return $this->by('user', $uuid, $options);
    }

    public function byTeam(string $uuid, ?array $options): Collection
    {
        return $this->by('organizations', $uuid, $options);
    }

    private function by(string $api, string $uuid, ?array $options): Collection
    {
        return $this->hydrate(
            (new ResultPager($this->client))->fetchAll($this->client->api($api), 'repositories', [$uuid]),
            Repository::class,
        );
    }
}
