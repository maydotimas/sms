<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\GradeLevelResource;
use App\Laravue\Models\Department;
use App\Laravue\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GradeLevelResource::collection(GradeLevel::with('department')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'department_id' => ['required','exists:departments,id']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $gradelevel = GradeLevel::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
                'department_id' => $params['department_id'],
            ]);

            return new GradeLevelResource($gradelevel);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function show(GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(GradeLevel $gradeLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradeLevel $gradeLevel)
    {
        if ($gradeLevel === null) {
            return response()->json(['error' => 'Grade Level not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'department_id' => ['required','exists:departments,id']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $gradeLevel->name = $params['name'];
            $gradeLevel->description = $params['description'];
            $gradeLevel->department_id = $params['department_id'];
            $gradeLevel->save();
        }

        return new GradeLevelResource($gradeLevel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\GradeLevel  $gradeLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradeLevel $gradeLevel)
    {
        try {
            $gradeLevel->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
