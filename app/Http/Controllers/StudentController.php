<?php

namespace App\Http\Controllers;

use App\AllStudent;
use App\ForeignStudent;
use App\LocalStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // input validation 
    public function inputValidation($request) {
        $validated = Validator::make($request->all(), [
            'student_type' => 'required|in:local,foreign',
            'id_number' => Route::currentRouteName() == "student.create" ?
            'required|between:1,99999|numeric|unique:local_students,id_number|unique:foreign_students,id_number' : 
            [
                'required',
                'between:1,99999', 
                'numeric',
                Rule::unique('local_students', 'id_number')->ignore($request->toEditStudentNumber, 'id_number'),
                Rule::unique('foreign_students', 'id_number')->ignore($request->toEditStudentNumber, 'id_number')
            ],
            'name' => Route::currentRouteName() == "student.create" ? 
            'required|min:6|unique:local_students,name|unique:foreign_students,name' :
            [
                'required',
                'min:6', 
                Rule::unique('local_students', 'name')->ignore($request->toEditStudentName, 'name'),
                Rule::unique('foreign_students', 'name')->ignore($request->toEditStudentName, 'name')
            ],
            'age' => 'required|integer|between:1,99',
            'gender' => 'required|in:male,female',
            'city' => 'required',
            'mobile_number' => 'required|min:11|max:11',
            'grades' => 'required|numeric|between:0,100',
            'email' => 'required|email'
        ]);
        return $validated;
    }
    // list student
    public function getStudent() {
        $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->get();
        $myArray = [];
        foreach($allStudents as $student) {
            $myArray[] = $student['foreignstudent'] ?? $student['localstudent'];
        }
        return $myArray;
    }
    // index
    public function index() {
        $title = "Student list";
        $allStudents = $this->getStudent();
        return view('template.home', compact('allStudents', 'title'));
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
    public function edit(Request $request) {
        $validated = $this->inputValidation($request);
        // if validator fails
        if($validated->fails()) {
            //if true
            return redirect()->back()->withErrors($validated)->withInput()->with('error', 'Failed to edit student!');
        } else {
            // ready data for creation of local or foreign student
            $createStudent = [
                'student_type' => $request->student_type,
                'id_number' => $request->id_number,
                'name' => $request->name,
                'age' => $request->age,
                'gender' => $request->gender,
                'city' => $request->city,
                'mobile_number' => $request->mobile_number,
                'grades' => $request->grades,
                'email' => $request->email
            ];
            $typeCheck = ($request->student_type == "local");
            LocalStudent::where('id_number', $request->toEditStudentNumber)->delete() == 1 ? : ForeignStudent::where('id_number', $request->toEditStudentNumber)->delete();
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