<?php

namespace Tests\Feature;

use App\Enums\TaskStatusEnum;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $created = User::factory(1)->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'jdc@test.com',
            'email_verified_at' => null,
        ]);

        $this->user = $created->count() ? $created[0] : $created;

        $this->tasks = Task::factory(15)->create();
    }

    public function test_fetch_user_tasks()
    {
        $userTasksCount = $this->user->tasks()->count();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson(route('tasks.index'));

        $response
            ->assertStatus(200)
            ->assertJsonCount($userTasksCount, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'status',
                        'due_date'
                    ]
                ]
            ]);
    }

    public function test_fetch_user_task()
    {
        $task = $this->user->tasks()->first();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson(route('tasks.show', $task->id));

        $response
            ->assertStatus(200)
            ->assertJsonFragment(TaskResource::make($task)->toArray(null));
    }

    public function test_create_user_task()
    {
        $data = [
            'user_id' => $this->user->id,
            'title' => 'Test Title',
            'description' => 'Test Description',
            'status' => 1,
            'due_date' => '2020-01-01'
        ];

        $response = $this->withoutExceptionHandling()
            ->actingAs($this->user, 'sanctum')
            ->postJson(route('tasks.store'), $data);

        $status = TaskStatusEnum::from(1);
        $data['status'] = $status->name;
        unset($data['user_id']);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($data, 'data')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'due_date'
                ]
            ]);
    }

    public function test_update_user_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Test Title',
            'description' => 'Test Description',
            'status' => 1,
            'due_date' => '2020-01-01'
        ]);

        $newData = [
            'title' => 'New Test Title',
            'description' => 'New Test Description',
            'status' => 2,
            'due_date' => '2023-02-02'
        ];

        $response = $this->withoutExceptionHandling()
            ->actingAs($this->user, 'sanctum')
            ->putJson(route('tasks.update', $task->id), $newData);

        $updatedData = $response->decodeResponseJson()['data'];

        $status = TaskStatusEnum::from($newData['status']);
        $newData['status'] = $status->name;
        $newData = array_merge(['id' => $task->id], $newData);

        $this->assertSame($updatedData, $newData);
    }

    public function test_delete_user_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Test Title',
            'description' => 'Test Description',
            'status' => 1,
            'due_date' => '2020-01-01'
        ]);

        $taskCount = Task::count();

        $this
            ->withoutExceptionHandling()
            ->actingAs($this->user, 'sanctum')
            ->delete(route('tasks.destroy', $task->id))
            ->assertStatus(200)
            ->assertSee('Task deleted successfully.');

        $newTaskCount = Task::count();

        $this->assertGreaterThan($newTaskCount, $taskCount);
        $this->assertEquals($taskCount - 1, $newTaskCount);
    }
}
