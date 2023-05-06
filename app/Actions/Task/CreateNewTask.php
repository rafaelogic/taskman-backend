<?php

namespace App\Actions\Task;

use App\Models\Task;

class CreateNewTask
{
    public function execute(array $task): Task|null
    {
        $user = auth()->user();
        return $user->tasks()->create($task);
    }
}
