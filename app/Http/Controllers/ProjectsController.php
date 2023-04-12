<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectsController extends Controller
{
    public function index(): View
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(): RedirectResponse
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    /**
     * @return array
     */
    protected function validateRequest(): array
    {
        return request()->validate([
            'title' => ['sometimes', 'required'],
            'description' => ['sometimes', 'required'],
            'notes' => ['nullable'],
        ]);
    }
}
