@extends('layout.layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
@endsection

@section('body')
    {{-- bread crumbs --}}
    <div class="text-sm breadcrumbs mt-[100px] w-full">
        <ul>
            <li><a href="{{ route('student') }}">Home</a></li> 
            <li></li>
        </ul>
    </div>

    {{-- filter --}}
    {{-- <div class="flex gap-5 w-full">
        <form action="{{ route('student') }}" class="form-control w-full max-w-[400px] flex flex-row gap-3">
            <div class="w-full">
                <label class="label">
                    <span class="label-text">Filter by type</span>
                </label>
                <select name="studentType" class="select select-bordered w-full">
                    <option value="">All</option>
                    <option value="foreign">Foreign</option>
                    <option value="local">Local</option>
                </select>
            </div>
            <button type="submit" class="btn self-end bg-blue-500 hover:bg-blue-400 text-white">Filter</button>
        </form>
    </div> --}}

    {{-- table --}}
    <div class="bg-white mt-5 w-full p-5 flex flex-col justify-between mb-3" id="tableContainer">
        <div id="table-container">
            <table class="studentTable display row-border table" style="width: 100%">
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
        <button id="deleteSelected" class="btn btn-error w-fit">Delete Selected</button>
    </div>

    {{-- add student button --}}
    <button id="showModalAdd" class="btn bg-blue-500 hover:bg-blue-400 text-white fixed bottom-[24px] right-[24px] shadow-md border-none">Add Student</button>

    {{-- modal --}}
    <div class="fixed top-0 bg-black/30 hidden justify-center items-center z-[2] w-full h-screen overflow-y-scroll" id="modal">
        <div class="flex flex-col w-full max-w-[800px] bg-white p-5 rounded-lg md:my-0 my-20">
            <div class="flex justify-between items-center">
                <h1 class="text-[20px] font-[700] text-blue-500" id="modalTitle">Add Student</h1>
                <button class="btn bi bi-x text-[20px]" id="hideModal"></button>
            </div>
            {{-- add student form --}}
            <form class="w-full flex flex-col" id="form">
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
                <button type="submit" class="btn bg-blue-500 hover:bg-blue-400 text-white self-end mt-3 w-full max-w-[200px]" id="">Save</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // show modal
            $("#showModalAdd").click(function() {
                modalReset();
                $("#modalTitle").html('Add student');
                $('#modal button').attr('id', 'save');
                $('#modal').addClass('flex').removeClass('hidden');
            });

            // hide modal
            $("#hideModal").click(function() {
                modalReset();
                $('#modal').addClass('hidden').removeClass('flex');
            });

            // reset modal
            function modalReset() {
                $('#modal button').attr('id', '');
                $("#modal span").html("");
                $("#modal input, #modal select").val("");
                $("#modal button").val("");
            }

            // data table function
            var table = $('.studentTable').DataTable({
                scrollX: true,
                processing: true,
                dom: 'BQlfrtip',
                // serverSide: true,
                select: {
                    style:    'multi',
                    selector: 'td:not(:last-child)'
                },
                searchBuilder: {
                    columns: [0,1,2,3,4,5,6,7,8]
                },  
                ajax: "{{ route('student') }}",
                method: "GET",
                columnDefs:
                [
                    {
                        targets: 7,
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    }
                ],
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

            // multidelete
            $('#deleteSelected').on('click', function() {
                let selectedIds = [];
                const selected = document.querySelectorAll('.list .selected .sorting_1');
                selected.forEach(element => {
                    selectedIds.push(element.innerText);
                });
                // confirm
                let title = 'Are you sure?';
                let text = 'Data will be deleted.';
                let icon = 'warning';
                let showCancelButton = true;
                let confirmButtonText = 'Yes, continue!';
                let cancelButtonText = 'Cancel';
                // confirmed callback
                function confirmedCallback(isConfirmed) {
                    if (isConfirmed) {
                        let method = "POST";
                        let url = "{{ route('student.multiDelete') }}";
                        let data = {id:selectedIds};
                        function successEvent(response) {
                            // toast success
                            success(response.message)
                            table.ajax.reload();
                        }
                        function errorEvent(response) {
                            // toast error
                            error(response.message)
                        }
                        // call ajax function
                        ajax(method, url, data, errorEvent, successEvent);
                    }
                }
                // call confirmation function
                confirmation(title, text, icon, showCancelButton = true, confirmButtonText, cancelButtonText, confirmedCallback);
            });

            // edit and delete process
            const actions = document.querySelector('.list');
            actions.addEventListener('click', (event)=>{
                event.preventDefault();
                // delete
                if(event.target.classList.contains('delete')) {
                    // confirm
                    let title = 'Are you sure?';
                    let text = 'Data will be deleted.';
                    let icon = 'warning';
                    let showCancelButton = true;
                    let confirmButtonText = 'Yes, continue!';
                    let cancelButtonText = 'Cancel';
                    // confirmed callback
                    function confirmedCallback(isConfirmed) {
                        if (isConfirmed) {
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
                            // call ajax function
                            ajax(method, url, data, errorEvent, successEvent);
                        }
                    }
                    // call confirmation function
                    confirmation(title, text, icon, showCancelButton = true, confirmButtonText, cancelButtonText, confirmedCallback);
                }
                // get student for edit
                else if(event.target.classList.contains('edit')) {
                    modalReset();
                    $('#modal button').attr('id', 'update');
                    $("#modalTitle").html('Edit student');
                    method = "POST";
                    url = "{{ route('student.editPage') }}";
                    data = {id_number:event.target.value};
                    function successEvent(response) {
                        // set input value 
                        $('#modal select[name=student_type]').val(response.data.student_type);
                        $('#modal input[name=id_number]').val(response.data.id_number);
                        $('#modal input[name=name]').val(response.data.name);
                        $('#modal input[name=age]').val(response.data.age);
                        $('#modal select[name=gender]').val(response.data.gender);
                        $('#modal input[name=city]').val(response.data.city);
                        $('#modal input[name=mobile_number]').val(response.data.mobile_number);
                        $('#modal input[name=grades]').val(response.data.grades);
                        $('#modal input[name=email]').val(response.data.email);
                        $('#modal button[type=submit]').val(response.data.id_number);
                    }
                    function errorEvent(response) {
                        // toast error
                        error(response.message)
                    }
                    ajax(method, url, data, errorEvent, successEvent);
                    $('#modal').addClass('flex').removeClass('hidden');
                }
            });

            // edit and create process
            const form = document.querySelector('#form');
            form.addEventListener('click', (event)=>{
                event.preventDefault();
                // create
                if(event.target.id == 'save') {
                    // confirm
                    let title = 'Are you sure?';
                    let text = "You're about to create student.";
                    let icon = 'warning';
                    let confirmButtonText = 'Yes, continue!';
                    let cancelButtonText = 'Cancel';
                    // confirmed callback
                    function confirmedCallback(isConfirmed) {
                        if (isConfirmed) {
                            let formData = $('#form').serialize();
                            method = "POST";
                            url = "{{ route('student.create') }}";
                            data = formData;
                            function successEvent(response) {
                                // reset error messages
                                $("#modal span").html("");
                                // reset inputs
                                $("#modal input, #form select").val("");
                                // toast success
                                success(response.message)
                                $('.studentTable').DataTable().ajax.reload();
                                $('#modal').addClass('hidden').removeClass('flex');
                            }
                            function errorEvent(response) {
                                // toast error
                                error(response.message)
                                // reset error messages
                                $("#modal span").html("");
                                // show error messages
                                $('#modal #errorStudentType').html(response.errors.student_type);
                                $('#modal #errorIdNumber').html(response.errors.id_number);
                                $('#modal #errorName').html(response.errors.name);
                                $('#modal #errorAge').html(response.errors.age);
                                $('#modal #errorGender').html(response.errors.gender);
                                $('#modal #errorCity').html(response.errors.city);
                                $('#modal #errorMobileNumber').html(response.errors.mobile_number);
                                $('#modal #errorGrades').html(response.errors.grades);
                                $('#modal #errorEmail').html(response.errors.email);
                            }
                            // call ajax funtion
                            ajax(method, url, data, errorEvent, successEvent);
                        }
                    }
                    // call confirmation function
                    confirmation(title, text, icon, showCancelButton = true, confirmButtonText, cancelButtonText, confirmedCallback);
                }
                // update
                else if(event.target.id == 'update') {
                    // confirm
                    let title = 'Are you sure?';
                    let text = "You're about to update student.";
                    let icon = 'warning';
                    let confirmButtonText = 'Yes, continue!';
                    let cancelButtonText = 'Cancel';
                    // confirmed callback
                    function confirmedCallback(isConfirmed) {
                        if (isConfirmed) {
                            let formData = $('#form').serialize();
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
                                $('#modal').addClass('hidden').removeClass('flex');
                                modalReset();
                            }
                            function errorEvent(response) {
                                // toast error
                                error(response.message)
                                // reset error messages
                                $("#modal span").html("");
                                // show error messages
                                $('#modal #errorStudentType').html(response.errors.student_type);
                                $('#modal #errorIdNumber').html(response.errors.id_number);
                                $('#modal #errorName').html(response.errors.name);
                                $('#modal #errorAge').html(response.errors.age);
                                $('#modal #errorGender').html(response.errors.gender);
                                $('#modal #errorCity').html(response.errors.city);
                                $('#modal #errorMobileNumber').html(response.errors.mobile_number);
                                $('#modal #errorGrades').html(response.errors.grades);
                                $('#modal #errorEmail').html(response.errors.email);
                            }
                            // call ajax function
                            ajax(method, url, data, errorEvent, successEvent);
                        }
                    }
                    // call confirmation function
                    confirmation(title, text, icon, showCancelButton = true, confirmButtonText, cancelButtonText, confirmedCallback);
                }
            })
        });
    </script>
@endsection