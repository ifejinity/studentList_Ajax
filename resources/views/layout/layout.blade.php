<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- cdns --}}
    @include('partials.__cdn')
    {{-- custom css --}}
    @yield('css')
</head>
<body class="w-full min-h-screen bg-gray-100 flex items-center flex-col font-[outfit] md:px-[10%] px-[5%] select-none">
    {{-- header --}}
    @if (Auth::check())
        <header class="w-full bg-white fixed top-0 px-[5%] py-3 flex justify-between shadow-lg z-[2] items-center">
            <div>
                <a href="{{ route('student') }}" class="text-blue-500 text-[20px] font-[600]">Student List</a>
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
    @yield('js')
    @if (Auth::check())
        <script>
            // logout
            const logoutLink = document.getElementById('logout');
                logoutLink.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will be logged out.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, log me out!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = logoutLink.href;
                        }
                    });
                });
        </script>
    @endif
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