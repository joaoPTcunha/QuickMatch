@include('home.css')

@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">

    <div class="flex-grow">
        @include('home.main')
    </div>

    @include('home.footer')
</body>
</html>
