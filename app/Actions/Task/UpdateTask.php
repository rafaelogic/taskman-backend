<?php

namespace App\Actions\Task;

use App\Models\Task;

class UpdateTask
{
    public function execute(Task $task, array $data): Task|null
    {
        $task->update($data);
        return $task->refresh();
    }
}
