@csrf

<div class="px-12 mb-3">
    <label for="title" class="text-xs">Title</label>

    <div class="mt-1">
        <input
            type="text"
            id="title"
            name="title"
            class="border w-full border h-8 rounded focus:outline-none px-4 py-2 text-sm shadow-sm"
            placeholder="My next awesome project"
            value="{{ $project->title }}"
            required
        >
    </div>
</div>

<div class="px-12 mb-3">
    <label for="description" class="text-xs">Description</label>

    <div class="mt-1">
                    <textarea
                        type="text"
                        id="description"
                        name="description"
                        class="border w-full border h-24 rounded focus:outline-none px-4 py-2 text-sm shadow-sm"
                        placeholder="I should start learn piano."
                        required
                    >{{ $project->description }}</textarea>
    </div>
</div>

<div class="px-12 mb-3">
    <div class="control">
        <button type="submit" class="button">{{ $buttonText }}</button>
        <a href="{{ $project->path() }}" class="underline ml-5 text-sky-500">Cancel</a>
    </div>
</div>

@include('errors')
