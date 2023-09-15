<?php

namespace App\Http\Controllers;

use App\AllStudent;
use App\ForeignStudent;
use App\LocalStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $data = $this->getStudent(); 
        if($request->ajax()) {
            return datatables()->of($data)->make(true);
        }  
        return view('template.home', compact( 'title'));
    }

    // create new student
    public function create(Request $request) {
        // validate inputs
        $validated = $this->inputValidation($request);
        // if validator ?
        if($validated->fails()) {
            //if true
            return response()->json(['status'=>500, 'message'=>'Invalid inputs.', 'errors'=>$validated->errors()]);
        } else {
            // if false
            $typeCheck = ($request->student_type == "local");
            $student = $typeCheck ? LocalStudent::create($request->all()) : ForeignStudent::create($request->all());
            $createAllStudent = [
                $typeCheck ? 'local_student_id' : 'foreign_student_id' => $student['id'],
                'student_type' => $student['student_type']
            ];
            AllStudent::create($createAllStudent);
            return response()->json(['status'=>200, 'message'=>'Added success.']);
        }
    }

    //get edit student
    public function editPage(Request $request) {
        $allStudents = $this->getStudent();
        $toEditStudent = "";
        foreach($allStudents as $student) {
            if($student->id_number == $request->id_number) {
                // format grades
                $student->grades = number_format($student->grades, 2);
                $toEditStudent = $student;
            }
        }
        if ($toEditStudent != null) {
            return response()->json(['status' => 200, 'data' => $toEditStudent]);
        }
    }

    // edit process
    public function edit(Request $request) {
        // validate
        $validated = $this->inputValidation($request, $request->old_id_number);
        // if validator fails
        if($validated->fails()) {
            //if true
            return response()->json(['status'=>500, 'message'=>'Invalid inputs.', 'errors'=>$validated->errors()]);
        } else {
            // ready data for creation of local or foreign student
            $createStudent = $request->all();
            $typeCheck = ($request->student_type == "local");
            LocalStudent::where('id_number', $request->old_id_number)->delete() == 1 ? : ForeignStudent::where('id_number', $request->old_id_number)->delete();
            $typeCheck ? $student = LocalStudent::create($createStudent) : $student = ForeignStudent::create($createStudent);
            // ready data for creation of records in all student table
            $createAllStudent = [
                $typeCheck ? 'local_student_id' : 'foreign_student_id' => $student['id'],
                'student_type' => $student['student_type']
            ];
            AllStudent::create($createAllStudent);
            return response()->json(['status'=>200, 'message'=>'Update success.']);
        }
    }

    // single delete
    public function delete(Request $request) {
        $allStudents = $this->getStudent();
        $toDeleteStudent = null;
        foreach($allStudents as $student) {
            if($student->number_id == $request->number_id) {
                $toDeleteStudent = $student;
                break;
            }
        }
        if ($toDeleteStudent != null) {
            $toDeleteStudent->student_type == "local" ?  LocalStudent::where('id_number', $toDeleteStudent->id_number)->delete() : ForeignStudent::where('id_number', $toDeleteStudent->id_number)->delete();
            return response()->json(['status'=>200, 'message' => 'Delete success.']);
        }
    }

    // multiple delete
    public function multiDelete(Request $request) {
        $validated = Validator::make($request->all(), [
            'id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $localCount = DB::table('local_students')->whereIn('id_number', $value)->count();
                    $foreignCount = DB::table('foreign_students')->whereIn('id_number', $value)->count();
                    if (($localCount + $foreignCount) !== count($value)) {
                        $fail("The selected student is invalid.");
                    }
                }
            ]
        ],
        [
            'id.required' => 'No selected.',
        ]);
        if($validated->fails()) {
            return response()->json(['status' => 500, 'message' => $validated->errors()]);
        } else {
            $ids = $request->id;
            ForeignStudent::whereIn('id_number', $ids)->delete();
            LocalStudent::whereIn('id_number', $ids)->delete();
            return response()->json(['status' => 200, 'message' => 'Delete success.']);
        }
    }
}