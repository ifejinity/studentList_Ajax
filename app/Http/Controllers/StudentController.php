<?php

namespace App\Http\Controllers;

use App\AllStudent;
use App\ForeignStudent;
use App\LocalStudent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // input validation 
    public function inputValidation($request, $numberId = null) {
        $validated = Validator::make($request->all(), [
            'student_type' => 'required|in:local,foreign',
            'id_number' => [
                'required', 'between:1,99999', 'numeric',
                Rule::unique('local_students', 'id_number')->ignore($numberId, 'id_number'),
                Rule::unique('foreign_students', 'id_number')->ignore($numberId, 'id_number')
            ],
            'mobile_number' => [
                'required', 'min:11', 'max:11', 'regex:#(09|\+639|\+63|0)[0-9]{9}#',
                Rule::unique('local_students', 'mobile_number')
                    ->where('name', $request->name)
                    ->ignore($numberId, 'id_number'),
                Rule::unique('foreign_students', 'mobile_number')
                    ->where('name', $request->name)
                    ->ignore($numberId, 'id_number'),
            ],
            'name' => [
                'required','min:6',
                Rule::unique('local_students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($numberId, 'id_number'),
                Rule::unique('foreign_students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($numberId, 'id_number'),
            ],
            'age' => 'required|integer|between:1,99',
            'gender' => 'required|in:male,female',
            'city' => 'required',
            'grades' => 'required|numeric|between:0,100',
            'email' => 'required|email'
        ], 
        // custom message
        [
            'name.unique' => 'Already registered with the same number.',
            'mobile_number.unique' => 'Already registered with the same name.',
        ]);
        return $validated;
    }
    // list filter
    public function filter($studentType = null) {
        $myArray = [];
        if($studentType == null) {
            $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->orderBy('created_at', 'desc')->get();
        } else {
            $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->where('student_type', $studentType)->orderBy('created_at', 'desc')->get();
        }
        foreach($allStudents as $student) {
            $myArray[] = $student['foreignstudent'] ?? $student['localstudent'];
        }
        return $myArray;
    }
    // list all student
    public function getStudent() {
        $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->get();
        $myArray = [];
        foreach($allStudents as $student) {
            $myArray[] = $student['foreignstudent'] ?? $student['localstudent'];
        }
        return $myArray;
    }
    // index
    public function index(Request $request) {
        $title = "Student list";
        $studentType = $request->studentType;
        $allStudents = $this->filter($studentType); 
        // Paginate the array
        $perPage = 6; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($allStudents, ($currentPage - 1) * $perPage, $perPage);
        $paginatedStudents = new LengthAwarePaginator($currentItems, count($allStudents), $perPage, $currentPage);
        $paginatedStudents->setPath($request->Url()."?studentType=".$studentType);
        return view('template.home', compact('paginatedStudents', 'title', 'studentType'));
    }
    // create new student
    public function create(Request $request) {
        // validate inputs
        $validated = $this->inputValidation($request);
        // if validator ?
        if($validated->fails()) {
            //if true
            return redirect()->back()->withErrors($validated)->withInput()->with('error', 'Failed to add student!');
        } else {
            // if false
            $typeCheck = ($request->student_type == "local");
            $student = $typeCheck ? LocalStudent::create($request->all()) : ForeignStudent::create($request->all());
            $createAllStudent = [
                $typeCheck ? 'local_student_id' : 'foreign_student_id' => $student['id'],
                'student_type' => $student['student_type']
            ];
            AllStudent::create($createAllStudent);
            return redirect()->route('student')->with('success', "Successfully added a student!");
        }
    }
    //get edit student
    public function editPage($numberId) {
        $title = "Student edit";
        $allStudents = $this->getStudent();
        $toEditStudent = "";
        foreach($allStudents as $student) {
            if($numberId == $student->id_number) {
                $toEditStudent = $student;
            }
        }
        if ($toEditStudent != null) {
            return view('template.edit', compact('title', 'toEditStudent'));
        } else {
            return redirect('404');
        }
    }
    // edit process
    public function edit(Request $request, $oldNumberId) {
        // validate
        $validated = $this->inputValidation($request, $oldNumberId);
        // if validator fails
        if($validated->fails()) {
            //if true
            return redirect()->back()->withErrors($validated)->withInput()->with('error', 'Failed to edit student!');
        } else {
            // ready data for creation of local or foreign student
            $createStudent = $request->all();
            $typeCheck = ($request->student_type == "local");
            LocalStudent::where('id_number', $oldNumberId)->delete() == 1 ? : ForeignStudent::where('id_number', $oldNumberId)->delete();
            $typeCheck ? $student = LocalStudent::create($createStudent) : $student = ForeignStudent::create($createStudent);
            // ready data for creation of records in all student table
            $createAllStudent = [
                $typeCheck ? 'local_student_id' : 'foreign_student_id' => $student['id'],
                'student_type' => $student['student_type']
            ];
            AllStudent::create($createAllStudent);
            return redirect()->route('student')->with('success', 'Edit saved!');
        }
    }
    // delete
    public function delete($numberId) {
        $allStudents = $this->getStudent();
        $toDeleteStudent = "";
        foreach($allStudents as $student) {
            if($numberId == $student->id_number) {
                $toDeleteStudent = $student;
            }
        }
        if ($toDeleteStudent != null) {
            $toDeleteStudent->student_type == "local" ?  LocalStudent::where('id_number', $toDeleteStudent->id_number)->delete() 
            : ForeignStudent::where('id_number', $toDeleteStudent->id_number)->delete();
            return redirect()->route('student')->with('success', 'Student delete success!');
        } else {
            return redirect('404');
        }
    }
}