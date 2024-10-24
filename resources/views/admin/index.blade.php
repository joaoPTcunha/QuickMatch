@include('admin.css')
@include('admin.header')

<body class="flex flex-col min-h-screen bg-gray-100">

    <div class="flex-grow">
        @include('admin.main') 
    </div>
    
    @include('admin.footer')
</body>
</html>