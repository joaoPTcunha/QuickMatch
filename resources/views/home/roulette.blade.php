
@include('home.css')
<style>
        .wheel {
            position: relative;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            border: 1px solid #ccc;
            overflow: hidden;
        }

        .wheel-section {
            position: absolute;
            width: 50%;
            height: 100%;
            text-align: center;
            line-height: 400px;
            font-size: 20px;
        }
    </style>
       
<body class="bg-gray-100 flex flex-col min-h-screen">

    @include('home.header')

    <div class="container mx-auto">
        <div class="flex justify-center items-center">
            <div class="wheel">
                </div>
            <button class="bg-red-500 rounded-full p-2 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">Girar</button>
        </div>
        <div class="mt-10">
            <h2 class="text-2xl font-bold">Resultado</h2>
            <div class="grid grid-cols-3 gap-4 mt-4">
                </div>
        </div>
        <div class="mt-10">
            <input type="text" id="nomeJogador" class="border border-gray-400 p-2" placeholder="Nome do jogador">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" id="adicionarJogador">Adicionar</button>
        </div>
    </div>
    @include('home.footer')

   