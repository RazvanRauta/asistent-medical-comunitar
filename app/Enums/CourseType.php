<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns;

enum CourseType: string
{
    use Concerns\Enums\Arrayable;
    use Concerns\Enums\Comparable;

    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case OTHER = 'other';

    protected function translationKeyPrefix(): ?string
    {
        return 'course.type';
    }
}
