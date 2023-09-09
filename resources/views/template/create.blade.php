@extends('layout.layout')

@section('body')
    {{-- bread crumbs --}}
    <div class="text-sm breadcrumbs mt-[100px] w-full">
        <ul>
            <li><a href="{{ route('student') }}">Home</a></li> 
            <li>Add student</li>
        </ul>
    </div>
    {{-- add student form --}}
    <form class="w-full bg-white shadow-md p-5 rounded-lg flex flex-col my-auto max-w-[700px]" action="{{ route('student.create') }}" method="POST" id="createForm">
        @csrf
        <h1 class="text-[30px] font-[700] text-blue-500 mb-1">Add student</h1>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            {{-- student type --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Student type</span>
                </label>
                <select name="student_type" class="select bg-gray-200">
                    <option value="" disabled {{ old('student_type') == null ? "selected" : '' }}>Select</option>
                    <option value="local" {{ old('student_type') == "local" ? "selected" : '' }}>Local</option>
                    <option value="foreign" {{ old('student_type') == "foreign" ? "selected" : '' }}>Foreign</option>
                </select>
                @error('student_type')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
            {{-- id number --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">ID number</span>
                </label>
                <input type="number" name="id_number" value="{{ old('id_number') }}" class="input bg-gray-200">
                @error('id_number')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            {{-- name --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" class="input bg-gray-200">
                @error('name')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
            {{-- age --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Age</span>
                </label>
                <input type="number" name="age" value="{{ old('age') }}" class="input bg-gray-200">
                @error('age')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            {{-- gender --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Gender</span>
                </label>
                <select name="gender" class="select bg-gray-200">
                    <option disabled {{ old('gender') == null ? "selected" : '' }}>Select</option>
                    <option value="male" {{ old('gender') == "male" ? "selected" : '' }}>Male</option>
                    <option value="female" {{ old('gender') == "female" ? "selected" : '' }}>Female</option>
                </select>
                @error('gender')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
            {{-- city --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">City</span>
                </label>
                <input type="text" name="city" value="{{ old('city') }}" class="input bg-gray-200">
                @error('city')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            {{-- mobile number --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Mobile number</span>
                </label>
                <input type="number" name="mobile_number" value="{{ old('mobile_number') }}" class="input bg-gray-200">
                @error('mobile_number')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
            {{-- grades --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Grades</span>
                </label>
                <input type="text" name="grades" value="{{ old('grades') }}" class="input bg-gray-200">
                @error('grades')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
            {{-- email --}}
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="text" name="email" value="{{ old('email') }}" class="input bg-gray-200">
                @error('email')<span class="text-[14px] text-red-500 text-red-500 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <button type="submit" class="btn bg-blue-500 hover:bg-blue-400 text-white self-end mt-3 w-full max-w-[200px]">Save</button>
    </form>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // save edit
            const updateForm = document.querySelector("#createForm");
            updateForm.addEventListener('submit', (event)=> {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You're about to create student",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            })
        });
    </script>
@endsection