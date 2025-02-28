<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use App\Http\Resources\StudentsResource;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Students::get();
        if($students->count() > 0)
        {
            return StudentsResource::collection($students);
        }
        else
        {
            return response()->json(['message' => 'No students available'], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'class' => 'required',
            'gender' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->messages()
            ], 423);
        }
        $request->validate([
            'name' => 'required',
            'class' => 'required',
            'gender' => 'required'
        ]);

        $students = Students::create([
            'name' => $request->name,
            'class' => $request->class,
            'gender' => $request->gender
        ]);

        return response()->json([
            'message' => 'Student created successfully',
            'data' => new StudentsResource($students)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $students = Students::find($id);

        if (!$students) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'class' => 'required|string',
            'gender' => 'required|string',
        ]);

        $students->update([
            'name' => $request->name,
            'class' => $request->class,
            'gender' => $request->gender
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data updated succesfully',
            'data' => $students
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $students = Students::find($id);

        // Jika data siswa tidak ditemukan
        if (!$students) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $students->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dihapus',
            'data' => $students
        ]);
    }
}
