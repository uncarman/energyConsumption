@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success') && is_array(session('success')) && count(session('success')) > 0)
    <div class="alert alert-success">
        <ul>
            @foreach(session('success') as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
@elseif(session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success') }}</li>
        </ul>
    </div>
@endif
