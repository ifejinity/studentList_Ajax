@extends('layout.layout')

@section('header')
    <div class="w-full bg-white fixed top-0 px-[5%] py-3 flex justify-between shadow-lg">
        <div>

        </div>
        <div>
            <a href="{{ route('logout.process') }}" class="btn bg-blue-500 hover:bg-blue-400 text-white" id="logout">Sign out</a>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // logout
            const logoutLink = document.getElementById('logout');
            logoutLink.addEventListener('click', function (e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will be logged out.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, log me out!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = logoutLink.href;
                    }
                });
            });
        });
    </script>
@endsection