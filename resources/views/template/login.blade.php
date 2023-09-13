@extends('layout.layout')

@section('body')
    <form class="w-full max-w-[600px] h-fit bg-white rounded-lg shadow-lg md:p-8 p-5 flex flex-col mx-[5%] my-auto" id="loginForm">
        @csrf
        <h1 class="text-[30px] font-[700] text-blue-500 mb-3">Sign in</h1>
        <input type="text" name="email" placeholder="Email" class="input bg-gray-200">
        <span class="text-red-500 text-[14px] text-red-500 mt-1" id="errorEmail"></span>
        <input type="password" name="password" placeholder="Password" class="input bg-gray-200 mt-3">
        <span class="text-red-500 text-[14px] text-red-500 mt-1" id="errorPassword"></span>
        <div class="form-control w-fit mt-1">
            <label class="label cursor-pointer flex gap-2">
                <span class="label-text">Remember me</span> 
                <input name="rememberMe" type="checkbox" class="checkbox checkbox-sm" />
            </label>
        </div>
        <button type="submit" class="btn w-full max-w-[200px] self-end bg-blue-500 hover:bg-blue-400 text-white mt-3" id="signIn">Sign in</button>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // sign in
            $("#signIn").click(function (e) { 
                e.preventDefault();
                let email = $('input[name=email]').val();
                let password = $('input[name=password]').val();
                let method = "POST";
                let url = "{{ route('login.process') }}";
                let data = {email:email, password:password};
                function successEvent(response) {
                    // reset error messages
                    $("#loginForm span").html("");
                    success(response.message)
                    setTimeout(() => {
                        window.location.href = "{{ route('student') }}";
                    }, 1000);
                }
                function errorEvent(response) {
                    error(response.message)
                    // reset and set error messages
                    $("#loginForm span").html("");
                    $('#errorEmail').html(response.errors.email)
                    $('#errorPassword').html(response.errors.password)
                }
                ajax(method, url, data, errorEvent, successEvent);
            });
        });
    </script>
@endsection
