@extends('layout.layout')

@section('body')
    <form action="{{ route('login.process') }}" method="POST" class="w-full max-w-[600px] h-fit bg-white rounded-lg shadow-lg md:p-8 p-5 flex flex-col mx-[5%] my-auto">
        @csrf
        <h1 class="text-[30px] font-[700] text-blue-500 mb-3">Sign in</h1>
        <input type="text" name="email" placeholder="Email" class="input bg-gray-200">
        @error('email')
            <span class="text-red-500 text-[14px] text-red-500 mt-1">{{ $message }}</span>
        @enderror
        <input type="password" name="password" placeholder="Password" class="input bg-gray-200 mt-3">
        @error('password')
            <span class="text-red-500 text-[14px] text-red-500 mt-1">{{ $message }}</span>
        @enderror
        <div class="form-control w-fit mt-1">
            <label class="label cursor-pointer flex gap-2">
                <span class="label-text">Remember me</span> 
                <input name="rememberMe" type="checkbox" class="checkbox checkbox-sm" />
            </label>
        </div>
        <button type="submit" class="btn w-full max-w-[200px] self-end bg-blue-500 hover:bg-blue-400 text-white mt-3">Sign in</button>
    </form>
@endsection
