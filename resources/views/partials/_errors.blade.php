@if ($errors->any())
    <div class="alert alert-danger" id="session-alert">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (session('error'))

    <script>
        new Noty({
            type: 'error',
            theme: 'bootstrap-v4',
            layout: 'topRight',
            text: "{{ session('error') }}",
            timeout: 1500,
            killer: true
        }).show();
    </script>

@endif