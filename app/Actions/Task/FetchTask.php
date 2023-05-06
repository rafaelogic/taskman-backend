<?php

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class FetchTask
{
    public function execute(?int $id = null): Collection|Task|null
    {
        $user = auth()->user();

        if (is_null($id)) {
            return $user->tasks()->get();
        }

        return $user->tasks()->findOrFail($id);
    }
}
