<div class="px-12 mt-3">
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <li class="text-xs text-red-500">{{ $error }}</li>
        @endforeach
    @endif
</div>
