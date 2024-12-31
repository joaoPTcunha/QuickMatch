@include('home.css')

@include('home.header')

<body class="flex flex-col min-h-screen bg-gray-100">
    <div class="flex-grow">
    <div class="flex-1 container mx-auto px-4 py-6">
        <h1 class="text-4xl text-center mb-12 text-gray-800 font-semibold">Contactos</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Criadores</h2>
                <p class="text-gray-600">José Amorim</p>
                <p class="text-gray-600">João Cunha</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Telefone</h2>
                <p class="text-gray-600">+351 123 456 789</p>
                <p class="text-gray-600">+351 987 654 321</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">E-mail</h2>
                <p class="text-gray-600">info@quickmatch.com</p>
                <p class="text-gray-600">suporte@quickmatch.com</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Redes Sociais</h2>
                <div class="flex space-x-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.877v-6.988h-2.54v-2.889h2.54v-2.217c0-2.513 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.471h-1.261c-1.243 0-1.629.774-1.629 1.563v1.878h2.775l-.444 2.889h-2.331v6.988C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                    <a href="#" class="text-pink-500 hover:text-pink-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.056 2.008.24 2.462.408a4.606 4.606 0 011.653.998 4.606 4.606 0 01.998 1.653c.168.454.352 1.292.408 2.462.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.056 1.17-.24 2.008-.408 2.462a4.606 4.606 0 01-.998 1.653 4.606 4.606 0 01-1.653.998c-.454.168-1.292.352-2.462.408-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.056-2.008-.24-2.462-.408a4.606 4.606 0 01-1.653-.998 4.606 4.606 0 01-.998-1.653c-.168-.454-.352-1.292-.408-2.462-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.056-1.17.24-2.008.408-2.462a4.606 4.606 0 01.998-1.653 4.606 4.606 0 011.653-.998c.454-.168 1.292-.352 2.462-.408 1.266-.058 1.646-.07 4.85-.07M12 0C8.741 0 8.332.012 7.052.07 5.775.128 4.63.308 3.75.707a6.805 6.805 0 00-2.43 1.585A6.805 6.805 0 00.707 3.75c-.4.88-.579 2.025-.637 3.302C0 8.332 0 8.741 0 12s.012 3.668.07 4.948c.058 1.277.237 2.422.637 3.302a6.805 6.805 0 001.585 2.43 6.805 6.805 0 002.43 1.585c.88.4 2.025.579 3.302.637C8.332 24 8.741 24 12 24s3.668-.012 4.948-.07c1.277-.058 2.422-.237 3.302-.637a6.805 6.805 0 002.43-1.585 6.805 6.805 0 001.585-2.43c.4-.88.579-2.025.637-3.302C24 15.668 24 15.259 24 12s-.012-3.668-.07-4.948c-.058-1.277-.237-2.422-.637-3.302a6.805 6.805 0 00-1.585-2.43 6.805 6.805 0 00-2.43-1.585c-.88-.4-2.025-.579-3.302-.637C15.668 0 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@include('home.footer')
</body>
</html>

