<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;


    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get("{$project->path()}/edit")->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => fake()->sentence,
            'description' => fake()->sentence,
            'notes' => 'General notes here',
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = Project::factory()->create();

        $attributes = [
            'title' => 'Changed',
            'description' => 'Changed',
            'notes' => 'Changed',
        ];

        $this->actingAs($project->owner);

        $this->get("{$project->path()}/edit")->assertOk();

        $this->patch($project->path(), $attributes)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_project_general_notes()
    {
        $project = Project::factory()->create();

        $attributes = ['notes' => 'Changed'];

        $this->actingAs($project->owner);

        $this->patch($project->path(), $attributes);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_their_projects()
    {
        $project = Project::factory()->create();

        $this->actingAs($project->owner);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $project = Project::factory()->create();

        $this->signIn();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $project = Project::factory()->create();

        $this->signIn();

        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
