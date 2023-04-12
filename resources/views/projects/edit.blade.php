@extends('layouts.app')

@section('content')
    <div class="card max-w-2xl mx-auto">
        <h1 class="font-normal text-center text-2xl py-8">Edit Your Project</h1>

        <form
            method="POST"
            action="{{ $project->path() }}"
        >
            @method('PATCH')

            @include('projects.form', [
                'buttonText' => 'Update Project'
            ])
        </form>
    </div>
@endsection
