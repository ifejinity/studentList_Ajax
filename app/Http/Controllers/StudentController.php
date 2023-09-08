<?php

namespace App\Http\Controllers;

use App\AllStudent;
use App\ForeignStudent;
use App\LocalStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // input validation 
    public function inputValidation($request, $number_id) {
        $validated = Validator::make($request->all(), [
            'student_type' => 'required|in:local,foreign',
            'id_number' => Route::currentRouteName() == "student.create" ?
            'required|between:1,99999|numeric|unique:local_students,id_number|unique:foreign_students,id_number' : 
            [
                'required', 'between:1,99999', 'numeric',
                Rule::unique('local_students', 'id_number')->ignore($number_id, 'id_number'),
                Rule::unique('foreign_students', 'id_number')->ignore($number_id, 'id_number')
            ],
            'mobile_number' => [
                'required', 'min:11', 'max:11',
                Rule::unique('local_students', 'mobile_number')
                    ->where('name', $request->name)
                    ->ignore($number_id, 'id_number'),
                Rule::unique('foreign_students', 'mobile_number')
                    ->where('name', $request->name)
                    ->ignore($number_id, 'id_number'),
            ],
            'name' => [
                'required','min:6',
                Rule::unique('local_students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($number_id, 'id_number'),
                Rule::unique('foreign_students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($number_id, 'id_number'),
            ],
            'age' => 'required|integer|between:1,99',
            'gender' => 'required|in:male,female',
            'city' => 'required',
            'grades' => 'required|numeric|between:0,100',
            'email' => 'required|email'
        ], 
        // custom message
        [
            'name.unique' => 'The name and number is already registered!',
            'mobile_number.unique' => '',
        ]);
        return $validated;
    }
    // list filter
    public function filter($studentType) {
        if($studentType == null) {
            $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->get();
        } else {
            $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->where('student_type', $studentType)->get();
        }
        $myArray = [];
        foreach($allStudents as $student) {
            $myArray[] = $student['foreignstudent'] ?? $student['localstudent'];
        }
        return $myArray;
    }
    // list filter
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
        return view('template.home', compact('allStudents', 'title', 'studentType'));
    }
    // create new student
    public function create(Request $request) {
        // validate inputs
        $validated = $this->inputValidation($request, $request->id_number);
        // if validator ?
        if($validated->fails()) {
            //if true
            return redirect()->back()->withErrors($validated)->withInput()->with('error', 'Failed to add student!');
        } else {
            // if false
            $typeCheck = ($request->input('student_type') == "local");
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
    public function editPage($id_number) {
        $title = "Student edit";
        $allStudents = $this->getStudent();
        $toEditStudent = "";
        foreach($allStudents as $student) {
            if($id_number == $student->id_number) {
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
    public function edit(Request $request, $old_number_id) {
        // validate
        $validated = $this->inputValidation($request, $old_number_id);
        // if validator fails
        if($validated->fails()) {
            //if true
            return redirect()->back()->withErrors($validated)->withInput()->with('error', 'Failed to edit student!');
        } else {
            // ready data for creation of local or foreign student
            $createStudent = $request->all();
            $typeCheck = ($request->student_type == "local");
            LocalStudent::where('id_number', $old_number_id)->delete() == 1 ? : ForeignStudent::where('id_number', $old_number_id)->delete();
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
    public function delete($id_number) {
        $allStudents = $this->getStudent();
        $toDeleteStudent = "";
        foreach($allStudents as $student) {
            if($id_number == $student->id_number) {
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