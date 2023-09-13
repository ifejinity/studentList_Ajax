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
    {{-- <div class="flex gap-5 w-full">
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
            <button type="submit" class="btn self-end bg-blue-500 hover:bg-blue-400 text-white">Filter</button>
        </form>
    </div> --}}
    {{-- table --}}
    <div class="bg-white mt-5 w-full p-5 flex flex-col justify-between mb-3">
        <div id="table-container">
            <table class="studentTable rounded-none display" style="width: 100%">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th>ID number</th>
                        <th>Student type</th>
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
                    
                </tbody>
            </table>
        </div>
    </div>
    {{-- add student button --}}
    <button id="showModalAdd" class="btn bg-blue-500 hover:bg-blue-400 text-white fixed bottom-[24px] right-[24px] shadow-md border-none">Add Student</button>
    {{-- modal add --}}
    <div class="fixed top-0 bg-black/30 hidden justify-center items-center z-[2] w-full h-screen overflow-y-scroll" id="modalAdd">
        <div class="flex flex-col w-full max-w-[800px] bg-white p-5 rounded-lg md:my-0 my-20">
            <div class="flex justify-between items-center">
                <h1 class="text-[20px] font-[700] text-blue-500">Add Student</h1>
                <button class="btn bi bi-x text-[20px]" id="hideModalAdd"></button>
            </div>
            {{-- add student form --}}
            <form class="w-full flex flex-col" id="createForm">
                @csrf
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- student type --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Student type</p>
                        </label>
                        <select name="student_type" class="select bg-gray-200">
                            <option value="" disabled selected>Select</option>
                            <option value="local">Local</option>
                            <option value="foreign">Foreign</option>
                        </select>
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorStudentType"></span>
                    </div>
                    {{-- id number --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">ID number</p>
                        </label>
                        <input type="number" name="id_number" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorIdNumber"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- name --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Name</p>
                        </label>
                        <input type="text" name="name"class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorName"></span>
                    </div>
                    {{-- age --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Age</p>
                        </label>
                        <input type="number" name="age" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorAge"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- gender --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Gender</p>
                        </label>
                        <select name="gender" class="select bg-gray-200">
                            <option disabled selected>Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorGender"></span>
                    </div>
                    {{-- city --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">City</p>
                        </label>
                        <input type="text" name="city" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorCity"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- mobile number --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Mobile number</p>
                        </label>
                        <input type="number" name="mobile_number" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorMobileNumber"></span>
                    </div>
                    {{-- grades --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Grades</p>
                        </label>
                        <input type="text" name="grades" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorGrades"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- email --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Email</p>
                        </label>
                        <input type="text" name="email" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorEmail"></span>
                    </div>
                </div>
                <button type="submit" class="btn bg-blue-500 hover:bg-blue-400 text-white self-end mt-3 w-full max-w-[200px]" id="save">Save</button>
            </form>
        </div>
    </div>
    {{-- modal edit --}}
    <div class="fixed top-0 bg-black/30 hidden justify-center items-center z-[2] w-full h-screen overflow-y-scroll" id="modalEdit">
        <div class="flex flex-col w-full max-w-[800px] bg-white p-5 rounded-lg md:my-0 my-20">
            <div class="flex justify-between items-center">
                <h1 class="text-[20px] font-[700] text-blue-500">Edit Student</h1>
                <button class="btn bi bi-x text-[20px]" id="hideModalEdit"></button>
            </div>
            {{-- add student form --}}
            <form class="w-full flex flex-col" id="editForm">
                @csrf
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- student type --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Student type</p>
                        </label>
                        <select name="student_type" class="select bg-gray-200">
                            <option value="" disabled>Select</option>
                            <option value="local">Local</option>
                            <option value="foreign">Foreign</option>
                        </select>
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorStudentType"></span>
                    </div>
                    {{-- id number --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">ID number</p>
                        </label>
                        <input type="number" name="id_number" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorIdNumber"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- name --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Name</p>
                        </label>
                        <input type="text" name="name"class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorName"></span>
                    </div>
                    {{-- age --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Age</p>
                        </label>
                        <input type="number" name="age" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorAge"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- gender --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Gender</p>
                        </label>
                        <select name="gender" class="select bg-gray-200">
                            <option disabled>Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorGender"></span>
                    </div>
                    {{-- city --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">City</p>
                        </label>
                        <input type="text" name="city" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorCity"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- mobile number --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Mobile number</p>
                        </label>
                        <input type="number" name="mobile_number" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorMobileNumber"></span>
                    </div>
                    {{-- grades --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Grades</p>
                        </label>
                        <input type="text" name="grades" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorGrades"></span>
                    </div>
                </div>
                <div class="w-full flex md:flex-row flex-col md:gap-5 gap-none">
                    {{-- email --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <p class="label-text">Email</p>
                        </label>
                        <input type="text" name="email" class="input bg-gray-200">
                        <span class="text-[14px] text-red-500 text-red-500 mt-1" id="errorEmail"></span>
                    </div>
                </div>
                <button type="submit" class="btn bg-blue-500 hover:bg-blue-400 text-white self-end mt-3 w-full max-w-[200px]" id="update">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // data table function
            $('.studentTable').DataTable({
                select: 'multi',
                scrollX: true,
                rowReorder: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('student') }}",
                method: "GET",
                columns: [
                    { data: 'id_number'},
                    { data: 'student_type'},
                    { data: 'name'},
                    { data: 'age'},
                    { data: 'gender'},
                    { data: 'city'},
                    { data: 'mobile_number'},
                    { data: 'grades'},
                    { data: 'email'},
                    {
                        render: function(data, type, full, meta) {
                            return `
                                <div class="flex gap-2">
                                    <button type="button" class="btn bi bi-pencil-square bg-blue-500 hover:bg-blue-400 text-white text-[18px] edit" value="${full.id_number}"></button>
                                    <button type="button" class="btn bi bi-trash bg-red-500 hover:bg-red-400 text-white text-[18px] delete" value="${full.id_number}"></button>
                                </div>
                            `;
                        }
                    },
                ]
            });
            // edit and delete
            const actions = document.querySelector('.list');
            actions.addEventListener('click', (event)=>{
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
                            method = "POST";
                            url = "{{ route('student.delete') }}";
                            data = {id_number:event.target.value};
                            function successEvent(response) {
                                // toast success
                                success(response.message)
                                $('.studentTable').DataTable().ajax.reload();
                            }
                            function errorEvent(response) {
                                // toast error
                                error(response.message)
                            }
                            ajax(method, url, data, errorEvent, successEvent);
                        }
                    });
                } else if(event.target.classList.contains('edit')) {
                    method = "POST";
                    url = "{{ route('student.editPage') }}";
                    data = {id_number:event.target.value};
                    function successEvent(response) {
                        // set input value 
                        $('#editForm select[name=student_type]').val(response.data.student_type);
                        $('#editForm input[name=id_number]').val(response.data.id_number);
                        $('#editForm input[name=name]').val(response.data.name);
                        $('#editForm input[name=age]').val(response.data.age);
                        $('#editForm select[name=gender]').val(response.data.gender);
                        $('#editForm input[name=city]').val(response.data.city);
                        $('#editForm input[name=mobile_number]').val(response.data.mobile_number);
                        $('#editForm input[name=grades]').val(response.data.grades);
                        $('#editForm input[name=email]').val(response.data.email);
                        $('#editForm button[type=submit]').val(response.data.id_number);
                    }
                    function errorEvent(response) {
                        // toast error
                        error(response.message)
                    }
                    ajax(method, url, data, errorEvent, successEvent);
                    $('#modalEdit').addClass('flex').removeClass('hidden');
                }
            });
            // create
            const createForm = document.querySelector("#createForm");
            createForm.addEventListener('submit', (event)=> {
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
                        let formData = $('#createForm').serialize();
                        method = "POST";
                        url = "{{ route('student.create') }}";
                        data = formData;
                        function successEvent(response) {
                            // reset error messages
                            $("#createForm span").html("");
                            // reset inputs
                            $("#createForm input, #createForm select").val("");
                            // toast success
                            success(response.message)
                            $('.studentTable').DataTable().ajax.reload();
                            $('#modalAdd').addClass('hidden').removeClass('flex');
                        }
                        function errorEvent(response) {
                            // reset error messages
                            $("#createForm span").html("");
                            // show error messages
                            $('#errorStudentType').html(response.errors.student_type);
                            $('#errorIdNumber').html(response.errors.id_number);
                            $('#errorName').html(response.errors.name);
                            $('#errorAge').html(response.errors.age);
                            $('#errorGender').html(response.errors.gender);
                            $('#errorCity').html(response.errors.city);
                            $('#errorMobileNumber').html(response.errors.mobile_number);
                            $('#errorMobileGrades').html(response.errors.grades);
                            $('#errorEmail').html(response.errors.email);
                            // toast error
                            error(response.message)
                        }
                        ajax(method, url, data, errorEvent, successEvent);
                    }
                });
            })
            // edit proccess
            $("#update").click(function (event) { 
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You're about to update student",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = $('#editForm').serialize();
                        formData += '&old_id_number=' + event.target.value;
                        method = "POST";
                        url = "{{ route('student.edit') }}";
                        data = formData;
                        function successEvent(response) {
                            // reset error messages
                            $("editForm span").html("");
                            // reset inputs
                            $("#editForm input, #editForm select").val("");
                            // toast success
                            success(response.message)
                            $('.studentTable').DataTable().ajax.reload();
                            $('#modalEdit').addClass('hidden').removeClass('flex');
                            $("#createForm input, #createForm select").val("");
                        }
                        function errorEvent(response) {
                            // toast error
                            error(response.message)
                            // reset error messages
                            $("#editForm span").html("");
                            // show error messages
                            $('#editForm #errorStudentType').html(response.errors.student_type);
                            $('#editForm #errorIdNumber').html(response.errors.id_number);
                            $('#editForm #errorName').html(response.errors.name);
                            $('#editForm #errorAge').html(response.errors.age);
                            $('#editForm #errorGender').html(response.errors.gender);
                            $('#editForm #errorCity').html(response.errors.city);
                            $('#editForm #errorMobileNumber').html(response.errors.mobile_number);
                            $('#editForm #errorMobileGrades').html(response.errors.grades);
                            $('#editForm #errorEmail').html(response.errors.email);
                        }
                        ajax(method, url, data, errorEvent, successEvent);
                    }
                });
            });
            // show modal add
            $("#showModalAdd").click(function() {
                $('#modalAdd').addClass('flex').removeClass('hidden');
            });
            // hide modal add
            $("#hideModalAdd").click(function() {
                $('#modalAdd').addClass('hidden').removeClass('flex');
            });
            // hide modal edit
            $("#hideModalEdit").click(function() {
                $('#modalEdit').addClass('hidden').removeClass('flex');
            });
        });
    </script>
@endsection