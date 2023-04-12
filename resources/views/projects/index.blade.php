@extends('layouts.app')

@section('content')
    <header class="mb-3 flex items-center py-4">
        <div class="flex w-full items-end justify-between">
            <h2 class="text-sm font-normal text-gray-500">My Projects</h2>

            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main class="-mx-3 lg:flex lg:flex-wrap">
        @forelse($projects as $project)
            <div class="px-3 pb-6 lg:w-1/3">
                @include('projects.card')
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
@endsection
