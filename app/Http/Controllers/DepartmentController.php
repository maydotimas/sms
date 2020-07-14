<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Laravue\Models\Department;
use App\Laravue\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('title') && $request->input('title') != '') {
            $data = Department::search($request->title)
                ->paginate($request->limit);
        } else {
            $data = Department::paginate($request->limit);
        }

        return DepartmentResource::collection(['data' => $data]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $category = Department::create([
                'name' => $params['name'],
                'code' => strtolower($params['name']) . time(), // Just to make sure this value is unique
                'description' => $params['description'],
            ]);

            return new DepartmentResource($category);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Laravue\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Laravue\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Laravue\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        if ($department === null) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $department->name = $params['name'];
            $department->description = $params['description'];
            $department->save();
        }

        return new DepartmentResource($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Laravue\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
