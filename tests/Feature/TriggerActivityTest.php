<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->last()->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = Project::factory()->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = Project::factory()->create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task.blade.php', $project->activity->last()->description);
    }

    /** @test */
    public function completing_a_task()
    {
        $project = Project::factory()->hasTasks(1)->create();

        $this->actingAs($project->owner);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    /** @test */
    public function incompleting_a_task()
    {
        $project = Project::factory()->hasTasks(1)->create();

        $this->actingAs($project->owner);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => false,
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = Project::factory()->hasTasks(1)->create();

        $project->tasks->first()->delete();

        $this->assertEquals(3, $project->activity->count());
    }
}
