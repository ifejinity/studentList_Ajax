@extends('layout.layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('body')
    {{-- bread crumbs --}}
    <div class="text-sm breadcrumbs mt-[100px] w-full">
        <ul>
            <li><a href="{{ route('student') }}">Home</a></li> 
            <li></li>
        </ul>
    </div>
    <div class="flex gap-5 w-full">
        <form action="{{ route('student') }}" class="form-control w-full max-w-[400px] flex flex-row gap-3">
            <div class="w-full">
                <label class="label">
                    <span class="label-text">Filter by type</span>
                </label>
                <select name="studentType" class="select select-bordered w-full">
                    <option value=""  {{ $studentType == null ? 'selected' : '' }}>All</option>
                    <option value="foreign" {{ $studentType == 'foreign' ? 'selected' : '' }}>Foreign</option>
                    <option value="local" {{  $studentType == 'local' ? 'selected' : ''  }}>Local</option>
                </select>
            </div>
            <button type="submit" class="btn self-end bg-blue-500 hover:bg-blue-400 text-white">Submit</button>
        </form>
    </div>
    {{-- table --}}
    <div class="bg-white mt-5 w-full p-5 flex flex-col justify-between mb-3">
        <div class="overflow-x-auto" id="table-container">
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
                    @foreach ($paginatedStudents as $student)
                        <tr class="hover:bg-blue-50">
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
            @if (count($paginatedStudents) <= 0)
                <div class="w-full flex justify-center mt-10">
                    <p class="text-center text-[50px] font-[700] text-blue-300">No record</p>
                </div>
            @endif
        </div>
        {{ $paginatedStudents->links() }}
    </div>
    {{-- add student button --}}
    <a href="{{ route('student.createPage') }}" class="btn bg-blue-500 hover:bg-blue-400 text-white fixed bottom-[24px] right-[24px] shadow-md border-none">Add Student</a>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
            //enable scrolling with drag
            const tableContainer = document.querySelector('#table-container');
            let isDragging = false;
            let startScrollLeft = 0;
            let startX = 0;
            tableContainer.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.clientX;
                startScrollLeft = tableContainer.scrollLeft;
                tableContainer.style.cursor = 'grabbing';
            });
            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                const dx = e.clientX - startX;
                tableContainer.scrollLeft = startScrollLeft - dx;
            });
            document.addEventListener('mouseup', () => {
                isDragging = false;
                tableContainer.style.cursor = 'grab';
            });
        });
    </script>
@endsection