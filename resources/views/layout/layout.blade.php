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
<body class="w-full min-h-screen bg-gray-100 flex items-center flex-col font-[outfit] md:px-[10%] px-[5%] ">
    {{-- header --}}
    @if (request()->path() == "student" || request()->path() == "student/createPage")
        <header class="w-full bg-white fixed top-0 px-[5%] py-3 flex justify-between shadow-lg z-[2]">
            <div>

            </div>
            <div>
                <a href="{{ route('logout.process') }}" class="btn bg-blue-500 hover:bg-blue-400 text-white" id="logout">Sign out</a>
            </div>
        </header>
    @endif

    {{-- body --}}
    @yield('body')

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- toastify js --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- custom js --}}
    <script src="{{ asset('js/student.js') }}"></script>
    {{-- alert response --}}
    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                className: "info",
                style: {
                    background: "#ef4444",
                }
            }).showToast();
        </script>
    @endif
    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                className: "info",
                style: {
                    background: "#22c55e",  
                }
            }).showToast();
        </script>
    @endif
</body>
</html>