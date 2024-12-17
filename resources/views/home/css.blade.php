<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="QuickMatch - Sua plataforma ideal para organizar e participar de eventos!" />
    <title>QuickMatch</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet" />

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js'></script>

    <link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css' rel='stylesheet' />

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/index.js'])
    <style>
        .parent {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
        }

        .magicpattern {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center center;
            background-repeat: repeat;
            background-image: url("data:image/svg+xml;utf8,%3Csvg width=%222000%22 height=%221400%22 xmlns=%22http:%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath fill=%22%23f2f2fe%22 d=%22M0 0h2000v1400H0z%22%2F%3E%3Cpath d=%22M0 466h0c73.149-6.107 146.297-12.214 221-21s150.96-20.252 223-9c72.04 11.252 139.865 45.223 214 47 74.135 1.777 154.58-28.64 232-35 77.42-6.36 151.812 11.335 223 25 71.188 13.665 139.172 23.3 216 11s162.5-46.534 233-38c70.5 8.534 125.827 59.836 205 63 79.173 3.164 182.192-41.81 225-57 42.808-15.19 25.404-.595 48 14%22 fill=%22none%22 stroke=%22%23e5e5fe%22 stroke-width=%226%22 stroke-linecap=%22round%22%2F%3E%3Cpath d=%22M0 933h0c75.611 24.853 151.223 49.705 228 41 76.777-8.705 154.721-50.97 227-63 72.279-12.03 138.893 6.171 213 6 74.107-.171 155.707-18.715 229-6s138.28 56.689 207 63 141.17-25.041 220-34c78.83-8.959 164.037 4.475 236 11s130.682 6.141 213-5c82.318-11.141 188.234-33.04 230-37 41.766-3.96 19.383 10.02 37 24%22 fill=%22none%22 stroke=%22%23b6b6fc%22 stroke-width=%226%22 stroke-linecap=%22round%22%2F%3E%3C%2Fsvg%3E");
        }
    </style>
</head>

<div class='parent'>
    <div class="magicpattern"></div>
</div>

</html>