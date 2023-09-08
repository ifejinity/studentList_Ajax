@extends('layout.layout')

@section('body')
    {{-- bread crumbs --}}
    <div class="text-sm breadcrumbs mt-[100px] w-full">
        <ul>
            <li><a href="{{ route('student') }}">Home</a></li> 
            <li>Edit student</li>
        </ul>
    </div>
    {{-- add student form --}}
    <form class="w-full bg-white shadow-md p-5 rounded-lg flex flex-col gap-3 mt-5 max-w-[700px]" action="{{ route('student.edit') }}" method="POST">
        @csrf
        <h1 class="text-[30px] font-[700] text-blue-500 mb-1">Edit student</h1>
        <div class="flex flex-wrap gap-1">
            @error('student_type')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('id_number')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('name')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('age')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('gender')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('city')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('mobile_number')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('grades')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
            @error('email')<span class="text-[14px] text-red-500 ml-1 badge badge-error text-white">{{ $message }}</span>@enderror
        </div>
        <div class="w-full flex md:flex-row flex-col gap-3">
            {{-- student type --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Student type</span>
                </label>
                <select name="student_type" class="select bg-gray-200">
                    <option value="" disabled {{ $toEditStudent['student_type'] == null ? "selected" : '' }}>Select</option>
                    <option value="local" {{ $toEditStudent['student_type'] == "local" ? "selected" : '' }}>Local</option>
                    <option value="foreign" {{ $toEditStudent['student_type'] == "foreign" ? "selected" : '' }}>Foreign</option>
                </select>
            </div>
            {{-- id number --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">ID number</span>
                </label>
                <input type="number" name="id_number" value="{{ $toEditStudent['id_number'] }}" class="input bg-gray-200">
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col gap-3">
            {{-- name --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" value="{{ $toEditStudent['name'] }}" class="input bg-gray-200">
            </div>
            {{-- age --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Age</span>
                </label>
                <input type="number" name="age" value="{{ $toEditStudent['age'] }}" class="input bg-gray-200">
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col gap-3">
            {{-- gender --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Gender</span>
                </label>
                <select name="gender" class="select bg-gray-200">
                    <option disabled {{ $toEditStudent['gender'] == null ? "selected" : '' }}>Select</option>
                    <option value="male" {{ $toEditStudent['gender'] == "male" ? "selected" : '' }}>Male</option>
                    <option value="female" {{ $toEditStudent['gender'] == "female" ? "selected" : '' }}>Female</option>
                </select>
            </div>
            {{-- city --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">City</span>
                </label>
                <input type="text" name="city" value="{{ $toEditStudent['city'] }}" class="input bg-gray-200">
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col gap-3">
            {{-- mobile number --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Mobile number</span>
                </label>
                <input type="number" name="mobile_number" value="{{ $toEditStudent['mobile_number'] }}" class="input bg-gray-200">
            </div>
            {{-- grades --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Grades</span>
                </label>
                <input type="text" name="grades" value="{{ number_format($toEditStudent['grades'], 2) }}" class="input bg-gray-200">
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col gap-3">
            {{-- email --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="text" name="email" value="{{ $toEditStudent['email'] }}" class="input bg-gray-200">
            </div>
        </div>
        <input type="hidden" name="toEditStudentNumber" value="{{ $toEditStudent['id_number'] }}">
        <button type="submit" class="btn bg-blue-500 hover:bg-blue-400 text-white self-end mt-3 w-full max-w-[200px]">Update</button>
    </form>
@endsection