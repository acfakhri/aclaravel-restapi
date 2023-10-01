<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();

        return response()->json([
            "message" => "Succesfully fetched students",
            "data" => $students
        ],Response::HTTP_OK);
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "username" => "required|string|unique:students,username",
            "email" => "required|string|email:rfc,dns|unique:students,email",
            "password" => "required|string",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed validation",
                "errors" => $validator->errors()
            ],Response::HTTP_NOT_ACCEPTABLE);
        }
        $validated = $validator->validated();
        $validated ["password"] = bcrypt($validated["password"]);
        
        try{ $createdStudent = Student::create($validated);
        }catch(\Exception $e){
            return response()->json([
                "message" => "Failed created a new student",
                "error" => $e->getMessage()
            ]);
        }
        
        return response()->json([
            "message" => "Success created a new student",
            "data" => $createdStudent
        ]);

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "name" => "string",
            "username" => "string|unique:students,username",
            "email" => "string|email:rfc,dns|unique:students,email",
            "password" => "string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Failed validation",
                "errors" => $validator->errors()
            ],Response::HTTP_NOT_ACCEPTABLE);
        }

        $validated = $validator->validated();
        if(isset($validated["password"])){
            $validated ["password"] = bcrypt($validated["password"]);
        }
        
        try{ 
            $studentup = Student::findOrFail($id);
            $studentup->update($validated); 
        }
        catch(\Exception $e){
            return response()->json([
                "message" => "Failed created a new student",
                "error" => $e->getMessage()
            ]);
        }
        
        return response()->json([
            "message" => "Success updated a new student",
            "data" => $studentup
        ]);

    }
    public function show($id){
        $student = Student::findOrFail($id);

        return response()->json([
         "message" => "Succesfully see a student.",
         "data" => $student 
     ]);

     }

     public function delete($id){
        $student = Student::findOrFail($id);

        $student->delete();

        return response()->json([
            "message" => "Data sudah berhasil dihapus dengan id {$id}",
        ]);
     }
}
