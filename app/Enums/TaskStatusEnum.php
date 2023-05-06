<?php

namespace App\Enums;

enum TaskStatusEnum: int
{
    case Todo = 0;
    case InProgress = 1;
    case Done = 2;

    public function inverse(): string
    {
        return match($this) {
            self::Todo => 'Todo',
            self::InProgress => 'InProgress',
            self::Done => 'Done'
        };
    }
}
