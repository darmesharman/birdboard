<div class="card mt-3">
    <ul class="text-xs space-y-1">
        @foreach($project->activity as $activity)
            <li>
                @include("projects.activity.{$activity->description}")
            </li>
        @endforeach
    </ul>
</div>
