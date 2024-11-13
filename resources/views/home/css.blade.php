<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QuickMatch</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/index.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/heroicons@1.0.6/outline.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        @keyframes move {
            100% {
                transform: translate3d(0, 0, 1px) rotate(360deg);
            }
        }
        
        .background {
            position: fixed;
            width: 100vw;
            height: 100vh;
            top: 0;
            left: 0;
            background: #e5e7eb;
            z-index:-1;
            overflow: hidden;
        }
        
        .background span {
            width: 8vmin;
            height: 8vmin;
            border-radius: 8vmin;
            backface-visibility: hidden;
            position: absolute;
            animation: move;
            animation-duration: 18;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
        
        
        .background span:nth-child(0) {
            color: #5de57f;
            top: 82%;
            left: 33%;
            animation-duration: 80s;
            animation-delay: -284s;
            transform-origin: -6vw -6vh;
            box-shadow: 16vmin 0 2.711716617942039vmin currentColor;
        }
        .background span:nth-child(1) {
            color: #505087;
            top: 22%;
            left: 11%;
            animation-duration: 169s;
            animation-delay: -225s;
            transform-origin: 8vw 5vh;
            box-shadow: -16vmin 0 2.820790640229034vmin currentColor;
        }
        .background span:nth-child(2) {
            color: #5de57f;
            top: 100%;
            left: 20%;
            animation-duration: 8s;
            animation-delay: -150s;
            transform-origin: 23vw -1vh;
            box-shadow: -16vmin 0 2.6138683661938655vmin currentColor;
        }
        .background span:nth-child(3) {
            color: #505087;
            top: 30%;
            left: 39%;
            animation-duration: 137s;
            animation-delay: -30s;
            transform-origin: 14vw 18vh;
            box-shadow: -16vmin 0 2.7813715770629353vmin currentColor;
        }
        .background span:nth-child(4) {
            color: #505087;
            top: 80%;
            left: 100%;
            animation-duration: 78s;
            animation-delay: -194s;
            transform-origin: 15vw 3vh;
            box-shadow: 16vmin 0 2.038634809612274vmin currentColor;
        }
        .background span:nth-child(5) {
            color: #5de57f;
            top: 99%;
            left: 27%;
            animation-duration: 153s;
            animation-delay: -75s;
            transform-origin: 19vw 6vh;
            box-shadow: -16vmin 0 2.1446686270954003vmin currentColor;
        }
        .background span:nth-child(6) {
            color: #505087;
            top: 80%;
            left: 44%;
            animation-duration: 17s;
            animation-delay: -212s;
            transform-origin: 16vw -1vh;
            box-shadow: 16vmin 0 2.489616131248994vmin currentColor;
        }
        .background span:nth-child(7) {
            color: #505087;
            top: 14%;
            left: 81%;
            animation-duration: 202s;
            animation-delay: -88s;
            transform-origin: -3vw -21vh;
            box-shadow: 16vmin 0 2.5126256936007554vmin currentColor;
        }
        .background span:nth-child(8) {
            color: #505087;
            top: 78%;
            left: 73%;
            animation-duration: 198s;
            animation-delay: -158s;
            transform-origin: 18vw -13vh;
            box-shadow: -16vmin 0 2.836121583404876vmin currentColor;
        }
        .background span:nth-child(9) {
            color: #505087;
            top: 22%;
            left: 39%;
            animation-duration: 32s;
            animation-delay: -100s;
            transform-origin: -22vw -4vh;
            box-shadow: 16vmin 0 2.2444574065130536vmin currentColor;
        }
        .background span:nth-child(10) {
            color: #505087;
            top: 86%;
            left: 4%;
            animation-duration: 47s;
            animation-delay: -115s;
            transform-origin: -21vw 9vh;
            box-shadow: 16vmin 0 2.189959948323936vmin currentColor;
        }
        .background span:nth-child(11) {
            color: #505087;
            top: 78%;
            left: 81%;
            animation-duration: 223s;
            animation-delay: -313s;
            transform-origin: -8vw -13vh;
            box-shadow: 16vmin 0 2.0094329627934853vmin currentColor;
        }
        .background span:nth-child(12) {
            color: #505087;
            top: 29%;
            left: 3%;
            animation-duration: 110s;
            animation-delay: -34s;
            transform-origin: 0vw 4vh;
            box-shadow: -16vmin 0 2.4211540945837338vmin currentColor;
        }
        .background span:nth-child(13) {
            color: #5de57f;
            top: 38%;
            left: 68%;
            animation-duration: 7s;
            animation-delay: -74s;
            transform-origin: -17vw 19vh;
            box-shadow: 16vmin 0 2.109582530723075vmin currentColor;
        }
        .background span:nth-child(14) {
            color: #5de57f;
            top: 6%;
            left: 96%;
            animation-duration: 133s;
            animation-delay: -55s;
            transform-origin: 11vw -16vh;
            box-shadow: 16vmin 0 2.6375868593712264vmin currentColor;
        }
        .background span:nth-child(15) {
            color: #5de57f;
            top: 2%;
            left: 89%;
            animation-duration: 302s;
            animation-delay: -35s;
            transform-origin: -6vw 23vh;
            box-shadow: -16vmin 0 2.5689792926804893vmin currentColor;
        }
        .background span:nth-child(16) {
            color: #5de57f;
            top: 64%;
            left: 52%;
            animation-duration: 46s;
            animation-delay: -89s;
            transform-origin: 19vw -1vh;
            box-shadow: 16vmin 0 2.67241776308917vmin currentColor;
        }
        .background span:nth-child(17) {
            color: #505087;
            top: 22%;
            left: 37%;
            animation-duration: 209s;
            animation-delay: -73s;
            transform-origin: 10vw 6vh;
            box-shadow: -16vmin 0 2.292903223167104vmin currentColor;
        }
        .background span:nth-child(18) {
            color: #505087;
            top: 68%;
            left: 31%;
            animation-duration: 301s;
            animation-delay: -6s;
            transform-origin: 13vw -12vh;
            box-shadow: 16vmin 0 2.168825228229437vmin currentColor;
        }
        .background span:nth-child(19) {
            color: #5de57f;
            top: 61%;
            left: 37%;
            animation-duration: 79s;
            animation-delay: -318s;
            transform-origin: 4vw 8vh;
            box-shadow: -16vmin 0 2.329834401587477vmin currentColor;
        }
        
    </style>
</head>

<body class="bg-gray-200">
    <!-- Fundo animado -->
    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</body>
</html>
