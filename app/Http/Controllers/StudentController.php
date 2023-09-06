<?php

namespace App\Http\Controllers;

use App\AllStudent;
use App\ForeignStudent;
use App\LocalStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // list student
    public function index() {
        $allStudents = AllStudent::with(['localstudent', 'foreignstudent'])->get();
        $myArray = [];
        foreach($allStudents as $student) {
            $myArray[] = $student['foreignstudent'] ?? $student['localstudent'];
        }
        return view('template.home', compact('myArray'));
    }
    // create new student
    public function create(Request $request) {
        // validate inputs
        $validated = Validator::make($request->all(), [
            'student_type' => 'required|in:local,foreign',
            'id_number' => 'required|unique:local_students,id_number|unique:foreign_students,id_number|max:12',
            'name' => 'required|min:6',
            'age' => 'required|integer|between:1,99',
            'gender' => 'required|in:male,female',
            'city' => 'required',
            'mobile_number' => 'required',
            'grades' => 'required|numeric|between:0,100',
            'email' => 'required|email'
        ]);
        // if validator ?
        if($validated->fails()) {
            //if true
            return redirect()->back()->withErrors($validated)->withInput()->with('error', 'Failed to add student!');
        } else {
            // if false
            $typeCheck = ($request->input('student_type') == "local");
            if($typeCheck) {
                $student = LocalStudent::create($request->all());
            } else {
                $student = ForeignStudent::create($request->all());
            }
            $data = [
                $typeCheck ? 'local_student_id' : 'foreign_student_id' => $student['id'],
                'student_type' => $student['student_type']
            ];
            AllStudent::create($data);
            return redirect()->route('student')->with('success', "Successfully added a student!");
        }
    }
}