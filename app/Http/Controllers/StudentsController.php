<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function index()
    {
        return view('student.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ['required'],
            "last_name" => ['required'],
            "age" => ['required'],
            "phone" => ['required'],
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $student = new Students;
            $student->first_name = $request->input('first_name');
            $student->last_name = $request->input('last_name');
            $student->age = $request->input('age');
            $student->phone = $request->input('phone');
            $student->save();
            return response()->json([
                'status'=>200,
                'message'=>'Student Added Successfully!',
            ]);
        }
    }

    public function fetchstudent()
    {
        $students = Students::all();
        return response()->json([
            'students'=>$students,
        ]);
    }

    public function edit($id)
    {
        $student = Students::find($id);
        if($student)
        {
            return response()->json([
                'status'=>200,
                'student'=>$student,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Student Not Found!',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ['required'],
            "last_name" => ['required'],
            "age" => ['required'],
            "phone" => ['required'],
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $student = Students::find($id);
            if($student)
            {
                $student->first_name = $request->input('first_name');
                $student->last_name = $request->input('last_name');
                $student->age = $request->input('age');
                $student->phone = $request->input('phone');
                $student->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully!',
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Student Not Found!',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $student = Students::find($id);
        $student->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Student Deleted Successfuly!',
        ]);
    }
}
