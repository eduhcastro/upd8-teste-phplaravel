{{-- Alert base --}}
@if (Session::has('alert.config') || Session::has('alert.delete'))
    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif

    @if (config('sweetalert.theme') != 'default')
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
    @endif

    @if (config('sweetalert.alwaysLoadJS') === false && config('sweetalert.neverLoadJS') === false)
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @endif
    <script>
        @if (Session::has('alert.config'))
            Swal.fire({!! Session::pull('alert.config') !!});
        @endif
    </script>
@endif

{{-- Alerts das validações --}}
@if ($errors->any())
    @php
        $numError = 1;
    @endphp
    @foreach ($errors->all() as $error)
        <div class="swal_{{ $numError }}">
            <script>
                Swal.fire({
                    "title": "{{ $error }}",
                    "timer": 5000,
                    "width": "auto",
                    "padding": "1.25rem",
                    "showConfirmButton": false,
                    "showCloseButton": true,
                    "timerProgressBar": true,
                    "toast": true,
                    "icon": "error",
                    "position": "bottom-end"
                });
            </script>
        </div>
        @php
            $numError++;
        @endphp
    @endforeach
@endif
