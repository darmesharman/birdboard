@extends('layouts.app')

@section('content')
    <div class="card max-w-2xl mx-auto">
        <h1 class="font-normal text-center text-2xl py-8">Let's start something new</h1>

        <form
            method="POST"
            action="/projects"
        >
            @include('projects.form', [
                'project' => new App\Models\Project,
                'buttonText' => 'Create Project',
            ])
        </form>
    </div>
@endsection
