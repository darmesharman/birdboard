@extends('layouts.app')

@section('content')
    <header class="mb-3 flex items-center py-4">
        <div class="flex w-full items-end justify-between">
            <p class="text-sm font-normal text-gray-500">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>

            <a href="{{ "{$project->path()}/edit" }}" class="button">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="font-normal mb-3 text-gray-500 text-lg">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @method('PATCH')
                                @csrf

                                <div class="flex justify-between items-center">
                                    <input name="body" type="text" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500' : '' }}">
                                    <input name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf

                            <input type="text" placeholder="Add a new task..." class="w-full" name="body">
                        </form>
                    </div>
                </div>
                <div>
                    <h2 class="font-normal mb-3 text-gray-500 text-lg">General Notes</h2>

                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')

                        <textarea
                            name="notes"
                            class="card w-full mb-4"
                            style="min-height: 200px"
                            placeholder="Anything special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>

                    @include('errors')
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')

                @include('projects.activity.card')
            </div>
        </div>

    </main>
@endsection
