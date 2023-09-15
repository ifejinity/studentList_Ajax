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

    {{-- global js --}}
    <script>
        // confirmation function
        function confirmation(title, text, icon, showCancelButton = false, confirmButtonText, cancelButtonText, confirmedCallback) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: showCancelButton,
                confirmButtonText: confirmButtonText,
                cancelButtonText: cancelButtonText
            }).then((result) => {
                confirmedCallback(result.isConfirmed);
            });
        }
        // ajax function
        function ajax(method, url, data, errorCallback, successCallback) {
            $.ajax({
                type: method,
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    
                },
                success: function (response) {
                    console.log(response);

                    if(response.status == 200) {
                        // call success callback
                        successCallback(response);
                    } else {
                        // call error callback
                        errorCallback(response);
                    }

                }, 
                error: function (error) {
                    console.log(error);
                }
            });
        }
        // function for success toast
        function success(message) {
            Toastify({
                text: message,
                className: "info",
                style: {
                    background: "#22c55e",
                }
            }).showToast();
        }
        // function for error toast
        function error(message) {
            Toastify({
                text: message,
                className: "info",
                style: {
                    background: "#ef4444",
                }
            }).showToast();
        }
    </script>
</body>
</html>