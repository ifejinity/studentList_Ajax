<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    {{-- cdns --}}
    @include('partials.__cdn')
</head>
<body class="w-full min-h-screen bg-blue-300 flex justify-center items-center font-[outfit]">
    {{-- login page --}}
    @yield('loginForm')

    {{-- home --}}
    @yield('studentList')
    
    {{-- toastify js --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @yield('toastify')
</body>
</html>