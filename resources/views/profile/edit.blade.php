@include('home.css')

@if($usertype == 'admin' || $usertype == 'owner')
@include('admin.header')

@else
@include('home.header')

@endif


<body class="bg-gray-100 flex flex-col min-h-screen">
    <main class="container mx-auto px-4 py-2 flex-grow">
        <h2 class="text-4xl font-semibold text-gray-800 leading-tight mb-7 text-center">
            {{ __('Perfil') }}
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="p-6 bg-white shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <div class="p-6 bg-white shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
@include('home.footer')

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const preview = document.getElementById('profile-picture');
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>