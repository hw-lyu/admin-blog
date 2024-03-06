@if(session()->has('message'))
    <div class="absolute bottom-3 right-3 bg-purple-600 rounded px-5 py-2 text-white border border-black z-10">
        {{ session()->get('message') }}
    </div>
@endif

@if ($errors->any())
    <div class="absolute bottom-3 right-3 bg-purple-600 rounded px-5 py-2 text-white border border-black z-10">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
