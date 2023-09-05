@extends('layout.layout')

@section('loginForm')
    <form action="{{ route('login.process') }}" method="POST" class="w-full max-w-[600px] h-fit bg-white rounded-lg shadow-lg md:p-8 p-5 flex flex-col gap-3 mx-[5%]">
        @csrf
        <h1 class="text-[30px] font-[800] text-blue-500 mb-3">Sign in</h1>
        <input type="text" name="email" placeholder="Email" class="input bg-gray-200">
        @error('email')
            <p class="text-red-500 text-[14px]">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="Password" class="input bg-gray-200">
        @error('password')
            <p class="text-red-500 text-[14px]">{{ $message }}</p>
        @enderror
        <button type="submit" class="btn w-full max-w-[200px] self-end bg-blue-500 hover:bg-blue-400 text-white">Sign in</button>
    </form>
@endsection

@section('js')
    @if (session('error'))
        <script>
            Toastify({
                text: "Failed to log in",
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
                text: "Success to log in",
                className: "info",
                style: {
                    background: "#22c55e",  
                }
            }).showToast();
        </script>
    @endif
@endsection