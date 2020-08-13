@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            theme: 'bootstrap-v4',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 1500,
            killer: true
        }).show();
    </script>

@endif
