<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $project = Project::factory()->create();

        $this->signIn();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_task()
    {
        $project = Project::factory()->hasTasks(1)->create();

        $this->signIn();

        $this->patch($project->tasks->first()->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = Project::factory()->create();

        $this->actingAs($project->owner);

        $this->post($project->path() . '/tasks', ['body' => 'Test Tasks']);

        $this->get($project->path())
            ->assertSee('Test Tasks');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = Project::factory()->hasTasks(1)->create();

        $attributes = ['body' => 'changed'];

        $this->actingAs($project->owner);

        $this->patch($project->tasks->first()->path(), $attributes);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $project = Project::factory()->hasTasks(1)->create();

        $this->actingAs($project->owner);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true,
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->hasTasks(1)->create();

        $this->actingAs($project->owner);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true,
        ]);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false,
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = Project::factory()->create();

        $this->actingAs($project->owner);

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
