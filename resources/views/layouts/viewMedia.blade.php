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
            margin: 0;
        }

        .plyr__glass-link {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            z-index: 10;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .plyr--hide-controls .plyr__glass-link {
            opacity: 0;
            pointer-events: none;
        }

        .plyr__glass-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('head')
</head>
<body>

<video id="player" playsinline controls data-poster="/path/to/poster.jpg" style="width: 100%; height: auto;">
    <source src="{{ route('movie.stream', ['uuid' => $movie->id]) }}" type="video/mp4">
</video>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const video = document.getElementById("player");
        const entityId = "{{ $movie->id }}";

        // افزودن پوستر
        const width = Math.floor(video.offsetWidth);
        const height = Math.floor(video.offsetHeight);
        let imageUrl = `/movie-cover/${width}/${height}/${entityId}`;
        video.setAttribute("data-poster", imageUrl);

        // Plyr init
        const player = new Plyr(video);

        // لینک شیشه‌ای به سایت اصلی
        const glassLink = document.createElement("a");
        glassLink.href = "{{ $movie->getLink() }}";
        glassLink.innerText = "بازگشت به صفحه اطلاعات";
        glassLink.className = "plyr__glass-link";

        // اضافه به container اصلی Plyr
        const plyrContainer = video.closest(".plyr");
        plyrContainer.style.position = 'relative'; // لازم برای absolute
        plyrContainer.appendChild(glassLink);

        // تنظیم ادامه پخش از آخرین نقطه
        const lastSeenTime = {{ $lastSeenTime }};
        player.once('loadedmetadata', () => {
            if (lastSeenTime > 0) {
                player.currentTime = lastSeenTime;
            }
        });

        // ذخیره موقعیت پخش
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
