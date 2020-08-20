@if ($errors->any())
    <div class="alert alert-danger" id="session-alert">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif