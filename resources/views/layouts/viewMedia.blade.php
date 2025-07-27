<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'تماشای فیلم و سریال با نوین باکس')</title>
    <meta name="description" content="@yield('meta_description', 'نوین باکس، مرجع تماشای آنلاین فیلم، سریال، انیمیشن و مستند با کیفیت عالی و بدون محدودیت.')">
    <meta name="keywords" content="فیلم, سریال, انیمیشن, مستند, پخش آنلاین, تماشای فیلم, نوین باکس, vod">
    <meta name="author" content="نوین باکس">

    <meta name="language" content="fa">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('assets/theme/css/plyr.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/theme/js/plyr.min.js') }}"></script>
    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Vazirmatn;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('head')
</head>
<body style="margin: 0">
<video id="player" playsinline controls data-poster="/path/to/poster.jpg">
    <source src="{{ route('movie.stream', ['uuid' => $movie->id]) }}" type="video/mp4">
</video>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const el = document.getElementById("player");
        const width = Math.floor(el.offsetWidth);
        const height = Math.floor(el.offsetHeight);
        const entityId = "{{ $movie->id }}";
        let imageUrl = `/movie-cover/${width}/${height}/${entityId}`;
        el.setAttribute("data-poster", imageUrl);
        const player = new Plyr('#player');
        const lastSeenTime = {{ $lastSeenTime }};
        player.once('loadedmetadata', () => {
            if (lastSeenTime > 0) {
                player.currentTime = lastSeenTime;
            }
        });
        let lastSavedTime = 0;
        player.on('timeupdate', () => {
            const current = Math.floor(player.currentTime);
            if (current - lastSavedTime >= 10) {
                lastSavedTime = current;
                fetch('{{ route('movie.updateWatchPosition' , ['uuid' => $movie->id]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        seconds: current
                    })
                });
            }
        });
    });
</script>
</body>
</html>
