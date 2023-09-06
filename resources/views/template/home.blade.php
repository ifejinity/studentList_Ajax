@extends('layout.layout')

@section('body')
    {{-- bread crumbs --}}
    <div class="text-sm breadcrumbs mt-[100px] w-full">
        <ul>
            <li><a href="{{ route('student') }}">Home</a></li> 
            <li></li>
        </ul>
    </div>
    {{-- table --}}
    <div class="overflow-x-auto bg-white mt-5 w-full p-5">
        <table class="table">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th>Student type</th>
                    <th>ID number</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Mobile number</th>
                    <th>Grades</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myArray as $student)
                    <tr>
                        <td>{{ $student['student_type'] }}</td>
                        <td>{{ $student['id_number'] }}</td>
                        <td>{{ $student['name'] }}</td>
                        <td>{{ $student['age'] }}</td>
                        <td>{{ $student['gender'] }}</td>
                        <td>{{ $student['city'] }}</td>
                        <td>{{ $student['mobile_number'] }}</td>
                        <td>{{ number_format($student['grades'], 2) }}</td>
                        <td>{{ $student['email'] }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="http://" class="btn bi bi-pencil-square bg-blue-500 hover:bg-blue-400 text-white text-[18px]"></a>
                                <a href="http://" id="delete" class="btn bi bi-trash bg-red-500 hover:bg-red-400 text-white text-[18px]"></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- add student button --}}
    <a href="{{ route('student.createPage') }}" class="btn bg-blue-500 hover:bg-blue-400 text-white absolute bottom-[24px] right-[24px]">Add Student</a>
@endsection