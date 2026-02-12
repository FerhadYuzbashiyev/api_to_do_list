<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $response = $this->postJson('/api/task', [
            'title' => 'Test Task',
            'description' => 'Test description'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task'
        ]);
    }

    public function test_can_get_tasks()
    {
        Task::factory(3)->create();

        $response = $this->getJson('/api/task');

        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    public function test_can_show_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/task/{$task->id}");

        $response->assertStatus(200)->assertJsonFragment([
            'title' => $task->title
        ]);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/task/{$task->id}", [
            'title' => 'Updated'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated'
        ]);
    }
    
    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/task/{$task->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_can_complete_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/task/{$task->id}/complete");

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'COMPLETED'
        ]);
    }

}
