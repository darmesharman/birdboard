<div class="card" style="height: 200px;">
    <h3 class="-ml-5 border-l-4 border-sky-300 mb-3 py-4 pl-4 text-xl font-normal">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>

    <div class="text-gray-500">{{ str()->limit($project->description, 100) }}</div>
</div>
