<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public static function list(): array
    {
        return [
            self::NEW,
            self::IN_PROGRESS,
            self::COMPLETED,
        ];
    }
}
