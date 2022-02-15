<?php

declare(strict_types=1);

namespace Changelog\RepositoryLister\GitHub;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

final class Repository extends DataTransferObject
{
    public array $data;

    #[MapFrom('id')]
    public string $uuid;

    #[MapFrom('full_name')]
    public string $name;

    #[MapFrom('default_branch')]
    public string $branch;
}
