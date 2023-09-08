<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 | Page not found</title>
    {{-- cdns --}}
    @include('partials.__cdn')
</head>
<body class="w-full min-h-screen flex justify-center items-center flex-col px-[5%] md:px-[10%] gap-3">
    <img src="{{ asset('assets/images/404.jpg') }}" alt="" class="w-full max-w-[500px]">
    <a href="{{ route('student') }}" class="btn bg-blue-500 hover:bg-blue-400 text-white">Back to Homepage</a>
</body>
</html>