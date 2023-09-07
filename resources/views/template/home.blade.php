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
            <tbody class="list">
                @foreach ($allStudents as $student)
                    <tr>
                        {{-- <td>{{ $student['created_at']->diffForHumans() }}</td> --}}
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
                                <a href="{{ route('student.editPage', $student['id_number']) }}" class="btn bi bi-pencil-square bg-blue-500 hover:bg-blue-400 text-white text-[18px] edit"></a>
                                <a href="{{ route('student.delete', $student['id_number']) }}" class="btn bi bi-trash bg-red-500 hover:bg-red-400 text-white text-[18px] delete"></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($allStudents) <= 0)
            <div class="w-full flex justify-center mt-10">
                <p class="text-center text-[50px] font-[700] text-blue-300">No record</p>
            </div>
        @endif
    </div>
    {{-- add student button --}}
    <a href="{{ route('student.createPage') }}" class="btn bg-blue-500 hover:bg-blue-400 text-white absolute bottom-[24px] right-[24px] shadow-md border-none">Add Student</a>
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
            // delete
            const deleteBtn = document.querySelector('.list');
            deleteBtn.addEventListener('click', (event)=>{
                event.preventDefault();
                if(event.target.classList.contains('delete')) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Data will be deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, continue!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = event.target.href;
                        }
                    });
                } else if(event.target.classList.contains('edit')) {
                    window.location.href = event.target.href;
                }
            });
        });
    </script>
@endsection